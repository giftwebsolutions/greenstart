<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire\Enquiries;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\SysAdmin\Models\Enquiry;
use Modules\SysAdmin\Models\EnquiryAppointment;
use Modules\SysAdmin\Services\EnquiryWorkflowService;

class Workspace extends Component
{
    public int $enquiryId;

    public string $status = '';

    public string $priority = 'normal';

    public string $assignedTo = '';

    public bool $followUpOpen = false;

    public string $followUpType = 'call';

    public string $followUpSubject = '';

    public string $followUpScheduledAt = '';

    public string $followUpAssignedTo = '';

    public string $followUpNotes = '';

    public bool $appointmentOpen = false;

    public string $appointmentTitle = '';

    public string $appointmentStartsAt = '';

    public string $appointmentEndsAt = '';

    public string $appointmentType = 'in_person';

    public string $appointmentLocation = '';

    public string $appointmentAssignedTo = '';

    public string $appointmentNotes = '';

    public string $activityNote = '';

    public function mount(int $enquiryId): void
    {
        Gate::authorize('customer.enquiries.view');
        $enquiry = Enquiry::query()->findOrFail($enquiryId);
        $this->enquiryId = $enquiry->id;
        $this->status = (string) $enquiry->status;
        $this->priority = $enquiry->priority;
        $this->assignedTo = (string) ($enquiry->assigned_to ?? '');
    }

    public function updateStatus(): void
    {
        Gate::authorize('customer.enquiries.update');
        $validated = $this->validate(['status' => ['required', 'integer', Rule::in(array_keys(Enquiry::$statuses))]]);
        app(EnquiryWorkflowService::class)->changeStatus($this->enquiry(), (int) $validated['status']);
        $this->dispatch('toast', message: 'Status updated.');
    }

    public function saveAssignment(): void
    {
        Gate::authorize('customer.enquiries.update');
        $validated = $this->validate([
            'priority' => ['required', Rule::in(array_keys(Enquiry::$priorities))],
            'assignedTo' => ['nullable', 'integer', Rule::exists('users', 'id')],
        ], attributes: ['assignedTo' => 'assigned team member']);

        $enquiry = $this->enquiry();
        $enquiry->update(['priority' => $validated['priority'], 'assigned_to' => $validated['assignedTo'] ?: null]);
        app(EnquiryWorkflowService::class)->activity($enquiry, 'assignment', 'Ownership or priority updated.');
        $this->dispatch('toast', message: 'Assignment updated.');
    }

    public function openFollowUp(): void
    {
        Gate::authorize('customer.enquiries.update');
        $this->resetValidation();
        $this->followUpType = 'call';
        $this->followUpSubject = 'Follow up with '.$this->enquiry()->name;
        $this->followUpScheduledAt = now()->addDay()->setTime(10, 0)->format('Y-m-d\TH:i');
        $this->followUpAssignedTo = (string) ($this->enquiry()->assigned_to ?? auth()->id() ?? '');
        $this->followUpNotes = '';
        $this->followUpOpen = true;
    }

    public function addFollowUp(): void
    {
        Gate::authorize('customer.enquiries.update');
        $validated = $this->validate([
            'followUpType' => ['required', Rule::in(['call', 'email', 'whatsapp', 'meeting', 'task'])],
            'followUpSubject' => ['required', 'string', 'max:150'],
            'followUpScheduledAt' => ['required', 'date', 'after:now'],
            'followUpAssignedTo' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'followUpNotes' => ['nullable', 'string', 'max:5000'],
        ]);

        app(EnquiryWorkflowService::class)->addFollowUp($this->enquiry(), [
            'type' => $validated['followUpType'],
            'subject' => trim($validated['followUpSubject']),
            'scheduled_at' => $validated['followUpScheduledAt'],
            'assigned_to' => $validated['followUpAssignedTo'] ?: null,
            'notes' => filled($validated['followUpNotes']) ? trim($validated['followUpNotes']) : null,
        ]);
        $this->followUpOpen = false;
        $this->status = (string) $this->enquiry()->status;
        $this->dispatch('toast', message: 'Follow-up scheduled.');
    }

    public function completeFollowUp(int $followUpId): void
    {
        Gate::authorize('customer.enquiries.update');
        $followUp = $this->enquiry()->followUps()->findOrFail($followUpId);
        app(EnquiryWorkflowService::class)->completeFollowUp($followUp);
        $this->dispatch('toast', message: 'Follow-up completed.');
    }

    public function cancelFollowUp(int $followUpId): void
    {
        Gate::authorize('customer.enquiries.update');
        $followUp = $this->enquiry()->followUps()->findOrFail($followUpId);
        app(EnquiryWorkflowService::class)->cancelFollowUp($followUp);
        $this->dispatch('toast', message: 'Follow-up cancelled.');
    }

    public function openAppointment(): void
    {
        Gate::authorize('customer.enquiries.update');
        $this->resetValidation();
        $this->appointmentTitle = 'Consultation with '.$this->enquiry()->name;
        $this->appointmentStartsAt = now()->addDay()->setTime(11, 0)->format('Y-m-d\TH:i');
        $this->appointmentEndsAt = now()->addDay()->setTime(11, 30)->format('Y-m-d\TH:i');
        $this->appointmentType = 'in_person';
        $this->appointmentLocation = '';
        $this->appointmentAssignedTo = (string) ($this->enquiry()->assigned_to ?? auth()->id() ?? '');
        $this->appointmentNotes = '';
        $this->appointmentOpen = true;
    }

    public function addAppointment(): void
    {
        Gate::authorize('customer.enquiries.update');
        $validated = $this->validate([
            'appointmentTitle' => ['required', 'string', 'max:150'],
            'appointmentStartsAt' => ['required', 'date', 'after:now'],
            'appointmentEndsAt' => ['nullable', 'date', 'after:appointmentStartsAt'],
            'appointmentType' => ['required', Rule::in(array_keys(EnquiryAppointment::$meetingTypes))],
            'appointmentLocation' => ['nullable', 'string', 'max:255'],
            'appointmentAssignedTo' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'appointmentNotes' => ['nullable', 'string', 'max:5000'],
        ]);

        app(EnquiryWorkflowService::class)->scheduleAppointment($this->enquiry(), [
            'title' => trim($validated['appointmentTitle']),
            'starts_at' => $validated['appointmentStartsAt'],
            'ends_at' => $validated['appointmentEndsAt'] ?: null,
            'meeting_type' => $validated['appointmentType'],
            'location' => filled($validated['appointmentLocation']) ? trim($validated['appointmentLocation']) : null,
            'assigned_to' => $validated['appointmentAssignedTo'] ?: null,
            'notes' => filled($validated['appointmentNotes']) ? trim($validated['appointmentNotes']) : null,
        ]);
        $this->appointmentOpen = false;
        $this->dispatch('toast', message: 'Appointment scheduled.');
    }

    public function addNote(): void
    {
        Gate::authorize('customer.enquiries.update');
        $validated = $this->validate(['activityNote' => ['required', 'string', 'max:5000']], attributes: ['activityNote' => 'note']);
        app(EnquiryWorkflowService::class)->activity($this->enquiry(), 'note', trim($validated['activityNote']));
        $this->activityNote = '';
        $this->dispatch('toast', message: 'Note added.');
    }

    public function closePanel(): void
    {
        $this->followUpOpen = false;
        $this->appointmentOpen = false;
        $this->resetValidation();
    }

    public function render()
    {
        Gate::authorize('customer.enquiries.view');
        $enquiry = $this->enquiry()->load([
            'category:id,name', 'product:id,title', 'assignedUser:id,name,email',
            'followUps.assignedUser:id,name', 'appointments.assignedUser:id,name', 'activities.creator:id,name',
        ]);
        $users = User::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('sysadmin::livewire.enquiries.workspace', compact('enquiry', 'users'));
    }

    private function enquiry(): Enquiry
    {
        return Enquiry::query()->findOrFail($this->enquiryId);
    }
}
