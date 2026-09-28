<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Services;

use Illuminate\Support\Facades\DB;
use Modules\SysAdmin\Models\Enquiry;
use Modules\SysAdmin\Models\EnquiryAppointment;
use Modules\SysAdmin\Models\EnquiryFollowUp;

class EnquiryWorkflowService
{
    public function changeStatus(Enquiry $enquiry, int $status): Enquiry
    {
        return DB::transaction(function () use ($enquiry, $status): Enquiry {
            $from = (int) $enquiry->status;
            if ($from === $status) {
                return $enquiry;
            }

            $enquiry->update([
                'status' => $status,
                'last_contacted_at' => in_array($status, [Enquiry::STATUS_CONTACTED, Enquiry::STATUS_FOLLOW_UP], true) ? now() : $enquiry->last_contacted_at,
                'closed_at' => Enquiry::isClosedStatus($status) ? now() : null,
            ]);
            $this->activity(
                $enquiry,
                'status_change',
                'Status changed from '.(Enquiry::$statuses[$from] ?? $from).' to '.(Enquiry::$statuses[$status] ?? $status).'.',
                ['from' => $from, 'to' => $status],
            );

            return $enquiry->refresh();
        });
    }

    public function addFollowUp(Enquiry $enquiry, array $attributes): EnquiryFollowUp
    {
        return DB::transaction(function () use ($enquiry, $attributes): EnquiryFollowUp {
            $followUp = $enquiry->followUps()->create([
                ...$attributes,
                'created_by' => auth()->id(),
                'status' => EnquiryFollowUp::STATUS_PENDING,
            ]);
            if (in_array((int) $enquiry->status, [Enquiry::STATUS_NEW, Enquiry::STATUS_CONTACTED], true)) {
                $enquiry->update(['status' => Enquiry::STATUS_FOLLOW_UP]);
            }
            $this->syncNextFollowUp($enquiry);
            $this->activity($enquiry, 'follow_up', 'Follow-up scheduled for '.$followUp->scheduled_at->format('d M Y, h:i A').'.', ['follow_up_id' => $followUp->id]);

            return $followUp;
        });
    }

    public function completeFollowUp(EnquiryFollowUp $followUp, ?string $outcome = null): EnquiryFollowUp
    {
        return DB::transaction(function () use ($followUp, $outcome): EnquiryFollowUp {
            $followUp->update(['status' => EnquiryFollowUp::STATUS_COMPLETED, 'completed_at' => now(), 'outcome' => $outcome ?: 'completed']);
            $followUp->enquiry->update(['last_contacted_at' => now()]);
            $this->syncNextFollowUp($followUp->enquiry);
            $this->activity($followUp->enquiry, 'follow_up_completed', 'Follow-up completed: '.$followUp->subject.'.', ['follow_up_id' => $followUp->id, 'outcome' => $followUp->outcome]);

            return $followUp->refresh();
        });
    }

    public function cancelFollowUp(EnquiryFollowUp $followUp): EnquiryFollowUp
    {
        return DB::transaction(function () use ($followUp): EnquiryFollowUp {
            $followUp->update(['status' => EnquiryFollowUp::STATUS_CANCELLED]);
            $this->syncNextFollowUp($followUp->enquiry);
            $this->activity($followUp->enquiry, 'follow_up_cancelled', 'Follow-up cancelled: '.$followUp->subject.'.', ['follow_up_id' => $followUp->id]);

            return $followUp->refresh();
        });
    }

    public function scheduleAppointment(Enquiry $enquiry, array $attributes): EnquiryAppointment
    {
        return DB::transaction(function () use ($enquiry, $attributes): EnquiryAppointment {
            $appointment = $enquiry->appointments()->create([
                ...$attributes,
                'customer_name' => $enquiry->name,
                'mobile' => $enquiry->mobile,
                'email' => $enquiry->email,
                'created_by' => auth()->id(),
                'status' => 'scheduled',
            ]);
            $this->activity($enquiry, 'appointment', 'Appointment scheduled for '.$appointment->starts_at->format('d M Y, h:i A').'.', ['appointment_id' => $appointment->id]);

            return $appointment;
        });
    }

    public function updateAppointmentStatus(EnquiryAppointment $appointment, string $status): EnquiryAppointment
    {
        return DB::transaction(function () use ($appointment, $status): EnquiryAppointment {
            $from = $appointment->status;
            $appointment->update(['status' => $status]);
            if ($appointment->enquiry) {
                $this->activity($appointment->enquiry, 'appointment_status', 'Appointment changed from '.str($from)->headline().' to '.str($status)->headline().'.', ['appointment_id' => $appointment->id]);
            }

            return $appointment->refresh();
        });
    }

    public function activity(Enquiry $enquiry, string $type, string $description, array $properties = []): void
    {
        $enquiry->activities()->create([
            'created_by' => auth()->id(),
            'type' => $type,
            'description' => $description,
            'properties' => $properties ?: null,
        ]);
    }

    public function syncNextFollowUp(Enquiry $enquiry): void
    {
        $enquiry->update(['next_follow_up_at' => $enquiry->pendingFollowUps()->min('scheduled_at')]);
    }
}
