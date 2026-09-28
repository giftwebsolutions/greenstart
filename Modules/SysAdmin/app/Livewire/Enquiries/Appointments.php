<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire\Enquiries;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\SysAdmin\Models\Enquiry;
use Modules\SysAdmin\Models\EnquiryAppointment;
use Modules\SysAdmin\Services\EnquiryWorkflowService;

class Appointments extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: 'upcoming')]
    public string $period = 'upcoming';

    #[Url(except: '')]
    public string $assignedTo = '';

    public bool $formOpen = false;

    public string $enquiryId = '';

    public string $title = '';

    public string $startsAt = '';

    public string $endsAt = '';

    public string $meetingType = 'in_person';

    public string $location = '';

    public string $formAssignedTo = '';

    public string $notes = '';

    public function mount(): void
    {
        Gate::authorize('customer.enquiries.view');
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'status', 'period', 'assignedTo'], true)) {
            $this->resetPage();
        }
    }

    public function openForm(): void
    {
        Gate::authorize('customer.enquiries.update');
        $this->reset(['enquiryId', 'title', 'location', 'notes']);
        $this->startsAt = now()->addDay()->setTime(10, 0)->format('Y-m-d\TH:i');
        $this->endsAt = now()->addDay()->setTime(10, 30)->format('Y-m-d\TH:i');
        $this->meetingType = 'in_person';
        $this->formAssignedTo = (string) (auth()->id() ?? '');
        $this->formOpen = true;
        $this->resetValidation();
    }

    public function updatedEnquiryId(): void
    {
        $enquiry = filled($this->enquiryId) ? Enquiry::query()->find($this->enquiryId) : null;
        if ($enquiry && blank($this->title)) {
            $this->title = 'Consultation with '.$enquiry->name;
            $this->formAssignedTo = (string) ($enquiry->assigned_to ?? auth()->id() ?? '');
        }
    }

    public function save(): void
    {
        Gate::authorize('customer.enquiries.update');
        $validated = $this->validate([
            'enquiryId' => ['required', 'integer', Rule::exists('enquiries', 'id')],
            'title' => ['required', 'string', 'max:150'],
            'startsAt' => ['required', 'date', 'after:now'],
            'endsAt' => ['nullable', 'date', 'after:startsAt'],
            'meetingType' => ['required', Rule::in(array_keys(EnquiryAppointment::$meetingTypes))],
            'location' => ['nullable', 'string', 'max:255'],
            'formAssignedTo' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'notes' => ['nullable', 'string', 'max:5000'],
        ], attributes: ['enquiryId' => 'enquiry', 'startsAt' => 'start time', 'endsAt' => 'end time', 'meetingType' => 'meeting type', 'formAssignedTo' => 'assigned team member']);

        app(EnquiryWorkflowService::class)->scheduleAppointment(Enquiry::query()->findOrFail($validated['enquiryId']), [
            'title' => trim($validated['title']),
            'starts_at' => $validated['startsAt'],
            'ends_at' => $validated['endsAt'] ?: null,
            'meeting_type' => $validated['meetingType'],
            'location' => filled($validated['location']) ? trim($validated['location']) : null,
            'assigned_to' => $validated['formAssignedTo'] ?: null,
            'notes' => filled($validated['notes']) ? trim($validated['notes']) : null,
        ]);
        $this->formOpen = false;
        $this->dispatch('toast', message: 'Appointment scheduled.');
    }

    public function updateStatus(int $appointmentId, string $status): void
    {
        Gate::authorize('customer.enquiries.update');
        $validated = validator(['status' => $status], ['status' => ['required', Rule::in(array_keys(EnquiryAppointment::$statuses))]])->validate();
        app(EnquiryWorkflowService::class)->updateAppointmentStatus(EnquiryAppointment::query()->findOrFail($appointmentId), $validated['status']);
        $this->dispatch('toast', message: 'Appointment status updated.');
    }

    public function closeForm(): void
    {
        $this->formOpen = false;
        $this->resetValidation();
    }

    public function render()
    {
        Gate::authorize('customer.enquiries.view');
        $appointments = EnquiryAppointment::query()
            ->with(['enquiry:id,name,subject', 'assignedUser:id,name'])
            ->when(trim($this->search) !== '', function (Builder $query): void {
                $term = '%'.trim($this->search).'%';
                $query->where(fn (Builder $nested) => $nested->where('title', 'like', $term)->orWhere('customer_name', 'like', $term)->orWhere('mobile', 'like', $term)->orWhere('email', 'like', $term));
            })
            ->when($this->status !== '', fn (Builder $query) => $query->where('status', $this->status))
            ->when($this->assignedTo === 'unassigned', fn (Builder $query) => $query->whereNull('assigned_to'))
            ->when($this->assignedTo !== '' && $this->assignedTo !== 'unassigned', fn (Builder $query) => $query->where('assigned_to', (int) $this->assignedTo))
            ->when($this->period === 'today', fn (Builder $query) => $query->whereDate('starts_at', today()))
            ->when($this->period === 'upcoming', fn (Builder $query) => $query->where('starts_at', '>=', now()))
            ->when($this->period === 'past', fn (Builder $query) => $query->where('starts_at', '<', now()))
            ->orderBy('starts_at', $this->period === 'past' ? 'desc' : 'asc')
            ->paginate(15);

        $enquiries = Enquiry::query()->active()->latest('id')->limit(250)->get(['id', 'name', 'subject', 'assigned_to']);
        $users = User::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('sysadmin::livewire.enquiries.appointments', compact('appointments', 'enquiries', 'users'));
    }
}
