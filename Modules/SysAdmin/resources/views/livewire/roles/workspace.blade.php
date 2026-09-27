<div class="grid gap-5">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div><p class="text-xs font-bold uppercase tracking-[.12em] text-primary">Access control</p><h1 class="mt-1 text-[22px] font-bold tracking-tight text-ink">Roles &amp; permissions</h1><p class="mt-1 text-[13px] text-ink-muted">Create roles and control access by business area and action.</p></div>
        @can('sysadmin.role.create')
            <x-sysadmin::btn variant="primary" wire:click="createRole">{!! \Modules\SysAdmin\Support\Icon::get('plus', 'h-4 w-4') !!} New role</x-sysadmin::btn>
        @endcan
    </div>

    <div class="grid items-start gap-5 lg:grid-cols-[280px_minmax(0,1fr)]">
        <aside class="overflow-hidden rounded-xl border border-hairline bg-white shadow-sm lg:sticky lg:top-24">
            <div class="border-b border-hairline px-4 py-3"><h2 class="text-[13px] font-bold text-ink">Roles</h2><p class="mt-0.5 text-[11px] text-ink-muted">Select a role to configure.</p></div>
            <div class="grid gap-1 p-2">
                @foreach($this->roles as $role)
                    @php
                        $protected = in_array($role->name, ['super-admin', 'owner'], true);
                    @endphp
                    <button type="button" wire:click="selectRole('{{ $role->id }}')" class="flex min-h-12 items-center justify-between rounded-lg px-3 text-left {{ $selectedRoleId === (string) $role->id ? 'bg-primary-50 text-primary-600' : 'text-ink-soft hover:bg-[#fafbfc]' }}"><span><strong class="block text-[12.5px]">{{ $this->roleLabel($role->name) }}</strong><small class="text-[10.5px] font-normal text-ink-muted">{{ $role->users_count }} users</small></span>@if($protected)<span class="rounded-full bg-white px-2 py-1 text-[9px] font-bold uppercase text-primary shadow-sm">System</span>@else<span class="text-[11px] tabular-nums text-ink-muted">{{ $role->permissions_count }}</span>@endif</button>
                @endforeach
            </div>
        </aside>

        <main class="min-w-0">
            @if($this->selectedRole)
                @php
                    $protected = in_array($this->selectedRole->name, ['super-admin', 'owner'], true);
                @endphp
                <div class="grid gap-4">
                    <div class="flex flex-wrap items-start justify-between gap-3 rounded-xl border border-hairline bg-white p-4 shadow-sm">
                        <div><div class="flex items-center gap-2"><h2 class="text-base font-bold text-ink">{{ $this->roleLabel($this->selectedRole->name) }}</h2>@if($protected)<span class="rounded-full bg-primary-50 px-2 py-1 text-[9px] font-bold uppercase text-primary">Protected full access</span>@endif</div><p class="mt-1 text-xs text-ink-muted">{{ $protected ? 'This role bypasses permission checks and cannot be changed.' : count($selectedPermissions).' permissions selected for '.$this->selectedRole->users_count.' users.' }}</p></div>
                        <div class="flex gap-2">
                            @if(!$protected)
                                @can('sysadmin.role.update')<x-sysadmin::btn wire:click="editRole">Rename</x-sysadmin::btn>@endcan
                                @can('sysadmin.role.delete')<x-sysadmin::btn variant="danger" wire:click="confirmDeleteRole">Delete</x-sysadmin::btn>@endcan
                                @can('sysadmin.role.update')<x-sysadmin::btn variant="primary" wire:click="savePermissions">Save permissions</x-sysadmin::btn>@endcan
                            @endif
                        </div>
                    </div>
                    @error('selectedRoleId')<p class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-xs font-semibold text-red-700">{{ $message }}</p>@enderror

                    @if($protected)
                        <div class="rounded-xl border border-primary-50 bg-primary-50 p-5 text-[13px] text-primary-700"><strong>Full system access</strong><p class="mt-1 text-primary-600">Super administrators automatically pass every authorization check, including permissions introduced by future modules.</p></div>
                    @else
                        @foreach($permissionGroups as $group => $permissions)
                            @php
                                $names = array_keys($permissions);
                                $selectedCount = collect($names)->filter(fn($name) => in_array($name, $selectedPermissions, true))->count();
                            @endphp
                            <section class="overflow-hidden rounded-xl border border-hairline bg-white shadow-sm">
                                <div class="flex items-center justify-between border-b border-hairline bg-[#fafbfc] px-4 py-3"><div><h3 class="text-[13px] font-bold text-ink">{{ $group }}</h3><p class="mt-0.5 text-[11px] text-ink-muted">{{ $selectedCount }} of {{ count($permissions) }} enabled</p></div>@can('sysadmin.role.update')<button type="button" wire:click="toggleGroup('{{ $group }}')" class="text-xs font-semibold text-primary hover:underline">{{ $selectedCount === count($permissions) ? 'Clear group' : 'Select group' }}</button>@endcan</div>
                                <div class="grid sm:grid-cols-2 xl:grid-cols-3">
                                    @foreach($permissions as $permission => $label)
                                        <label class="flex min-h-14 cursor-pointer items-start gap-3 border-b border-hairline px-4 py-3 text-[12px] font-semibold text-ink sm:border-r"><input type="checkbox" value="{{ $permission }}" wire:model="selectedPermissions" @disabled(auth()->user()->cannot('sysadmin.role.update')) class="mt-0.5 size-4 shrink-0 rounded border-hairline-strong text-primary"><span>{{ $label }}<small class="mt-0.5 block break-all font-mono text-[9.5px] font-normal text-ink-muted">{{ $permission }}</small></span></label>
                                    @endforeach
                                </div>
                            </section>
                        @endforeach
                    @endif
                </div>
            @else
                <div class="rounded-xl border border-dashed border-hairline-strong p-12 text-center text-[13px] text-ink-muted">Create or select a role to configure permissions.</div>
            @endif
        </main>
    </div>

    @if($roleFormOpen)
        <div class="fixed inset-0 z-50 grid place-items-center bg-slate-950/40 p-4" role="dialog" aria-modal="true"><form wire:submit="saveRole" class="w-full max-w-md rounded-xl bg-white p-6 shadow-2xl"><h2 class="text-lg font-bold text-ink">{{ $editingRoleId ? 'Rename role' : 'Create role' }}</h2><p class="mt-1 text-xs text-ink-muted">Use a clear job-function name such as Catalog Manager.</p><div class="mt-5"><x-sysadmin::input label="Role name" name="roleName" wire:model="roleName" placeholder="Catalog Manager" required hint="Saved as a lowercase role identifier." /></div><div class="mt-6 flex justify-end gap-2"><x-sysadmin::btn wire:click="closeRoleForm">Cancel</x-sysadmin::btn><x-sysadmin::btn type="submit" variant="primary">Save role</x-sysadmin::btn></div></form></div>
    @endif

    @if($confirmingDelete)
        <div class="fixed inset-0 z-50 grid place-items-center bg-slate-950/40 p-4" role="dialog" aria-modal="true"><div class="w-full max-w-md rounded-xl bg-white p-6 shadow-2xl"><h2 class="text-lg font-bold text-ink">Delete role?</h2><p class="mt-2 text-[13px] text-ink-muted">Only roles with no assigned users can be deleted.</p><div class="mt-6 flex justify-end gap-2"><x-sysadmin::btn wire:click="$set('confirmingDelete', null)">Cancel</x-sysadmin::btn><x-sysadmin::btn variant="danger" wire:click="deleteRole">Delete role</x-sysadmin::btn></div></div></div>
    @endif
</div>
