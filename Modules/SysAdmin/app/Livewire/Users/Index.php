<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    public bool $drawerOpen = false;

    public ?int $editingId = null;

    public ?int $confirmingDelete = null;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $role = '';

    public bool $isActive = true;

    public string $password = '';

    public string $passwordConfirmation = '';

    public function mount(): void
    {
        Gate::authorize('sysadmin.user.view');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        Gate::authorize('sysadmin.user.create');
        $this->resetForm();
        $this->drawerOpen = true;
    }

    public function edit(int $userId): void
    {
        Gate::authorize('sysadmin.user.update');
        $user = User::query()->with('roles')->findOrFail($userId);

        $this->editingId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = (string) $user->phone;
        $this->role = $user->roles->first()?->name ?? '';
        $this->isActive = (bool) $user->is_active;
        $this->password = '';
        $this->passwordConfirmation = '';
        $this->resetValidation();
        $this->drawerOpen = true;
    }

    public function save(): void
    {
        Gate::authorize($this->editingId ? 'sysadmin.user.update' : 'sysadmin.user.create');
        Gate::authorize('sysadmin.user.assign_role');

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255', Rule::unique('users', 'email')->ignore($this->editingId)],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::exists('roles', 'name')->where('guard_name', 'web')],
            'isActive' => ['boolean'],
            'password' => [$this->editingId ? 'nullable' : 'required', 'string', 'min:8', 'same:passwordConfirmation'],
        ], attributes: ['isActive' => 'active status']);

        $actorIsProtected = auth()->user()?->hasAnyRole(['super-admin', 'owner']) ?? false;
        if (in_array($validated['role'], ['super-admin', 'owner'], true) && ! $actorIsProtected) {
            throw ValidationException::withMessages(['role' => 'Only a super administrator can assign this protected role.']);
        }

        DB::transaction(function () use ($validated): void {
            $user = $this->editingId ? User::query()->with('roles')->findOrFail($this->editingId) : new User;
            $protected = $user->exists && $user->hasAnyRole(['super-admin', 'owner']);

            if ($protected && (! $validated['isActive'] || ! in_array($validated['role'], ['super-admin', 'owner'], true))) {
                throw ValidationException::withMessages(['role' => 'A protected administrator cannot be deactivated or moved to a lower role.']);
            }

            $user->fill([
                'name' => trim($validated['name']),
                'email' => mb_strtolower(trim($validated['email'])),
                'phone' => filled($validated['phone']) ? trim($validated['phone']) : null,
                'is_active' => $validated['isActive'],
            ]);
            if (filled($validated['password'])) {
                $user->password = $validated['password'];
            }
            $user->save();
            $user->syncRoles([$validated['role']]);
        });

        $message = $this->editingId ? 'User updated.' : 'User created.';
        $this->drawerOpen = false;
        $this->resetForm();
        $this->dispatch('toast', message: $message);
    }

    public function confirmDelete(int $userId): void
    {
        Gate::authorize('sysadmin.user.delete');
        $user = User::query()->with('roles')->findOrFail($userId);

        if ($user->id === auth()->id() || $user->hasAnyRole(['super-admin', 'owner'])) {
            $this->dispatch('toast', message: 'Protected or currently signed-in users cannot be deleted.');

            return;
        }

        $this->confirmingDelete = $userId;
    }

    public function delete(): void
    {
        Gate::authorize('sysadmin.user.delete');
        $user = $this->confirmingDelete ? User::query()->with('roles')->find($this->confirmingDelete) : null;
        if ($user && $user->id !== auth()->id() && ! $user->hasAnyRole(['super-admin', 'owner'])) {
            $user->delete();
            $this->dispatch('toast', message: 'User deleted.');
        }
        $this->confirmingDelete = null;
        $this->resetPage();
    }

    public function closeDrawer(): void
    {
        $this->drawerOpen = false;
        $this->resetValidation();
    }

    public function render()
    {
        Gate::authorize('sysadmin.user.view');

        $users = User::query()
            ->with('roles')
            ->when(trim($this->search) !== '', fn ($query) => $query->where(function ($query): void {
                $term = '%'.trim($this->search).'%';
                $query->where('name', 'like', $term)->orWhere('email', 'like', $term)->orWhere('phone', 'like', $term);
            }))
            ->orderBy('name')
            ->paginate(15);

        $roles = Role::query()
            ->where('guard_name', 'web')
            ->when(! (auth()->user()?->hasAnyRole(['super-admin', 'owner']) ?? false), fn ($query) => $query->whereNotIn('name', ['super-admin', 'owner']))
            ->orderBy('name')
            ->get();

        return view('sysadmin::livewire.users.index', compact('users', 'roles'));
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'email', 'phone', 'role', 'password', 'passwordConfirmation']);
        $this->isActive = true;
        $this->resetValidation();
    }
}
