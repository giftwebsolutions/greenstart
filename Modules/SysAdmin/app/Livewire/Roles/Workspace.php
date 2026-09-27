<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire\Roles;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Modules\SysAdmin\Support\PermissionCatalog;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class Workspace extends Component
{
    public string $selectedRoleId = '';

    /** @var array<int, string> */
    public array $selectedPermissions = [];

    public bool $roleFormOpen = false;

    public ?int $editingRoleId = null;

    public string $roleName = '';

    public ?int $confirmingDelete = null;

    public function mount(): void
    {
        Gate::authorize('sysadmin.role.view');
        $first = Role::query()->where('guard_name', 'web')->orderByRaw("name IN ('super-admin', 'owner')")->orderBy('name')->first();
        if ($first) {
            $this->selectRole((string) $first->id);
        }
    }

    public function selectRole(string $roleId): void
    {
        Gate::authorize('sysadmin.role.view');
        $role = Role::query()->where('guard_name', 'web')->findOrFail($roleId);
        $this->selectedRoleId = (string) $role->id;
        $this->selectedPermissions = $role->permissions()->whereIn('name', PermissionCatalog::names())->pluck('name')->sort()->values()->all();
        $this->resetValidation();
    }

    public function toggleGroup(string $group): void
    {
        Gate::authorize('sysadmin.role.update');
        $this->guardSelectedRole();
        $names = array_keys(PermissionCatalog::groups()[$group] ?? []);
        $allSelected = collect($names)->every(fn (string $name): bool => in_array($name, $this->selectedPermissions, true));
        $this->selectedPermissions = $allSelected
            ? array_values(array_diff($this->selectedPermissions, $names))
            : array_values(array_unique([...$this->selectedPermissions, ...$names]));
    }

    public function savePermissions(): void
    {
        Gate::authorize('sysadmin.role.update');
        $role = $this->guardSelectedRole();
        $valid = Permission::query()->where('guard_name', 'web')->whereIn('name', $this->selectedPermissions)->whereIn('name', PermissionCatalog::names())->pluck('name')->all();
        $role->syncPermissions($valid);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->dispatch('toast', message: $this->roleLabel($role->name).' permissions updated.');
    }

    public function createRole(): void
    {
        Gate::authorize('sysadmin.role.create');
        $this->editingRoleId = null;
        $this->roleName = '';
        $this->roleFormOpen = true;
        $this->resetValidation();
    }

    public function editRole(): void
    {
        Gate::authorize('sysadmin.role.update');
        $role = $this->guardSelectedRole();
        $this->editingRoleId = $role->id;
        $this->roleName = $this->roleLabel($role->name);
        $this->roleFormOpen = true;
    }

    public function saveRole(): void
    {
        Gate::authorize($this->editingRoleId ? 'sysadmin.role.update' : 'sysadmin.role.create');
        $normalized = Str::slug(trim($this->roleName));
        $this->roleName = $normalized;
        $validated = $this->validate([
            'roleName' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('roles', 'name')->where('guard_name', 'web')->ignore($this->editingRoleId)],
        ], attributes: ['roleName' => 'role name']);

        if (in_array($validated['roleName'], ['super-admin', 'owner'], true)) {
            throw ValidationException::withMessages(['roleName' => 'This is a protected system role name.']);
        }

        $role = $this->editingRoleId
            ? Role::query()->where('guard_name', 'web')->findOrFail($this->editingRoleId)
            : new Role(['guard_name' => 'web']);
        if ($this->isProtected($role)) {
            throw ValidationException::withMessages(['roleName' => 'Protected roles cannot be renamed.']);
        }
        $role->name = $validated['roleName'];
        $role->guard_name = 'web';
        $role->save();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->roleFormOpen = false;
        $this->selectRole((string) $role->id);
        $this->dispatch('toast', message: $this->editingRoleId ? 'Role renamed.' : 'Role created.');
    }

    public function confirmDeleteRole(): void
    {
        Gate::authorize('sysadmin.role.delete');
        $role = $this->guardSelectedRole();
        if ($role->users()->exists()) {
            throw ValidationException::withMessages(['selectedRoleId' => 'Reassign this role’s users before deleting it.']);
        }
        $this->confirmingDelete = $role->id;
    }

    public function deleteRole(): void
    {
        Gate::authorize('sysadmin.role.delete');
        $role = $this->confirmingDelete ? Role::query()->find($this->confirmingDelete) : null;
        if ($role && ! $this->isProtected($role) && ! $role->users()->exists()) {
            $role->delete();
            app(PermissionRegistrar::class)->forgetCachedPermissions();
            $next = Role::query()->where('guard_name', 'web')->whereNotIn('name', ['super-admin', 'owner'])->orderBy('name')->first();
            $this->selectedRoleId = '';
            $this->selectedPermissions = [];
            if ($next) {
                $this->selectRole((string) $next->id);
            }
            $this->dispatch('toast', message: 'Role deleted.');
        }
        $this->confirmingDelete = null;
    }

    public function closeRoleForm(): void
    {
        $this->roleFormOpen = false;
        $this->resetValidation();
    }

    public function getRolesProperty(): Collection
    {
        return Role::query()->where('guard_name', 'web')->withCount(['permissions', 'users'])->orderBy('name')->get();
    }

    public function getSelectedRoleProperty(): ?Role
    {
        return $this->selectedRoleId !== '' ? Role::query()->withCount('users')->find($this->selectedRoleId) : null;
    }

    public function roleLabel(string $name): string
    {
        return Str::of($name)->replace(['-', '_'], ' ')->title()->toString();
    }

    public function render()
    {
        Gate::authorize('sysadmin.role.view');

        return view('sysadmin::livewire.roles.workspace', [
            'permissionGroups' => PermissionCatalog::groups(),
        ]);
    }

    private function guardSelectedRole(): Role
    {
        $role = Role::query()->where('guard_name', 'web')->findOrFail($this->selectedRoleId);
        if ($this->isProtected($role)) {
            throw ValidationException::withMessages(['selectedRoleId' => 'The super administrator role always has full access and cannot be modified.']);
        }

        return $role;
    }

    private function isProtected(Role $role): bool
    {
        return in_array($role->name, ['super-admin', 'owner'], true);
    }
}
