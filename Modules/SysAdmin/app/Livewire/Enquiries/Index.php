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
use Modules\SysAdmin\Models\EnquiryFollowUp;
use Modules\SysAdmin\Services\EnquiryWorkflowService;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: '')]
    public string $priority = '';

    #[Url(except: '')]
    public string $assignedTo = '';

    #[Url(except: '')]
    public string $followUp = '';

    #[Url(except: '')]
    public string $createdFrom = '';

    #[Url(except: '')]
    public string $createdTo = '';

    public int $perPage = 15;

    public function mount(): void
    {
        Gate::authorize('customer.enquiries.view');
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'status', 'priority', 'assignedTo', 'followUp', 'createdFrom', 'createdTo', 'perPage'], true)) {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'status', 'priority', 'assignedTo', 'followUp', 'createdFrom', 'createdTo']);
        $this->resetPage();
    }

    public function updateStatus(int $enquiryId, string $status): void
    {
        Gate::authorize('customer.enquiries.update');
        $validated = validator(['status' => $status], [
            'status' => ['required', 'integer', Rule::in(array_keys(Enquiry::$statuses))],
        ])->validate();

        app(EnquiryWorkflowService::class)->changeStatus(Enquiry::query()->findOrFail($enquiryId), (int) $validated['status']);
        $this->dispatch('toast', message: 'Enquiry status updated.');
    }

    public function render()
    {
        Gate::authorize('customer.enquiries.view');

        $enquiries = Enquiry::query()
            ->with(['assignedUser:id,name', 'product:id,title', 'latestPendingFollowUp'])
            ->when(trim($this->search) !== '', function (Builder $query): void {
                $term = '%'.trim($this->search).'%';
                $query->where(fn (Builder $nested) => $nested
                    ->where('name', 'like', $term)
                    ->orWhere('mobile', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('subject', 'like', $term)
                    ->orWhere('city', 'like', $term));
            })
            ->when($this->status !== '', fn (Builder $query) => $query->where('status', (int) $this->status))
            ->when($this->priority !== '', fn (Builder $query) => $query->where('priority', $this->priority))
            ->when($this->assignedTo === 'unassigned', fn (Builder $query) => $query->whereNull('assigned_to'))
            ->when($this->assignedTo !== '' && $this->assignedTo !== 'unassigned', fn (Builder $query) => $query->where('assigned_to', (int) $this->assignedTo))
            ->when($this->followUp === 'overdue', fn (Builder $query) => $query->whereHas('pendingFollowUps', fn (Builder $followUps) => $followUps->where('scheduled_at', '<', now())))
            ->when($this->followUp === 'today', fn (Builder $query) => $query->whereHas('pendingFollowUps', fn (Builder $followUps) => $followUps->whereDate('scheduled_at', today())))
            ->when($this->followUp === 'upcoming', fn (Builder $query) => $query->whereHas('pendingFollowUps', fn (Builder $followUps) => $followUps->where('scheduled_at', '>', now())))
            ->when($this->followUp === 'none', fn (Builder $query) => $query->whereDoesntHave('pendingFollowUps'))
            ->when($this->createdFrom !== '', fn (Builder $query) => $query->whereDate('created_at', '>=', $this->createdFrom))
            ->when($this->createdTo !== '', fn (Builder $query) => $query->whereDate('created_at', '<=', $this->createdTo))
            ->latest('id')
            ->paginate($this->perPage);

        $stats = [
            'new' => Enquiry::query()->where('status', Enquiry::STATUS_NEW)->count(),
            'overdue' => EnquiryFollowUp::query()->overdue()->count(),
            'appointments_today' => EnquiryAppointment::query()->whereDate('starts_at', today())->whereNotIn('status', ['cancelled'])->count(),
            'open' => Enquiry::query()->active()->count(),
        ];

        $users = User::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('sysadmin::livewire.enquiries.index', compact('enquiries', 'stats', 'users'));
    }
}
