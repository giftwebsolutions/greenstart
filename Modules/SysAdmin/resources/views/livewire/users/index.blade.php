<div class="grid gap-5">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.12em] text-primary">Access control</p>
            <h1 class="mt-1 text-[22px] font-bold tracking-tight text-ink">Users</h1>
            <p class="mt-1 text-[13px] text-ink-muted">Manage administrator accounts, status and assigned roles.</p>
        </div>
        @can('sysadmin.user.create')
            <x-sysadmin::btn variant="primary" wire:click="create">{!! \Modules\SysAdmin\Support\Icon::get('users', 'h-4 w-4') !!} Add user</x-sysadmin::btn>
        @endcan
    </div>

    <x-sysadmin::table-toolbar search-placeholder="Search by name, email or phone…" />

    <div class="overflow-x-auto rounded-xl border border-hairline bg-white shadow-sm">
        <table class="w-full min-w-[760px] border-collapse">
            <thead><tr><x-sysadmin::th>User</x-sysadmin::th><x-sysadmin::th>Role</x-sysadmin::th><x-sysadmin::th>Status</x-sysadmin::th><x-sysadmin::th>Last updated</x-sysadmin::th><x-sysadmin::th align="right">Actions</x-sysadmin::th></tr></thead>
            <tbody>
                @forelse($users as $user)
                    @php
                        $userRole = $user->roles->first()?->name;
                        $protected = in_array($userRole, ['super-admin', 'owner'], true);
                    @endphp
                    <tr wire:key="user-{{ $user->id }}" class="hover:bg-[#fafbfc]">
                        <x-sysadmin::td><div class="flex items-center gap-3"><span class="grid size-9 shrink-0 place-items-center rounded-full bg-primary-50 text-xs font-bold text-primary">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span><span><strong class="block text-[13px] text-ink">{{ $user->name }}</strong><small class="block text-[11.5px] text-ink-muted">{{ $user->email }}@if($user->phone) · {{ $user->phone }}@endif</small></span></div></x-sysadmin::td>
                        <x-sysadmin::td><span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-ink-soft">{{ $userRole ? str($userRole)->replace(['-', '_'], ' ')->title() : 'No role' }}</span>@if($protected)<span class="ml-1 text-[10px] font-bold uppercase text-primary">Protected</span>@endif</x-sysadmin::td>
                        <x-sysadmin::td><span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-bold {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-ink-muted' }}"><span class="size-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>{{ $user->is_active ? 'Active' : 'Inactive' }}</span></x-sysadmin::td>
                        <x-sysadmin::td><span class="text-[12px] text-ink-muted">{{ $user->updated_at?->diffForHumans() }}</span></x-sysadmin::td>
                        <x-sysadmin::td align="right"><div class="flex justify-end gap-1">@can('sysadmin.user.update')<x-sysadmin::icon-button icon="pencil" label="Edit user" wire:click="edit({{ $user->id }})" />@endcan @can('sysadmin.user.delete')<x-sysadmin::icon-button icon="trash" label="Delete user" danger wire:click="confirmDelete({{ $user->id }})" />@endcan</div></x-sysadmin::td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-14 text-center"><strong class="block text-[13px] text-ink">No users found</strong><span class="mt-1 block text-xs text-ink-muted">Try another search or create an administrator.</span></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>{{ $users->links() }}</div>

    @if($drawerOpen)
        <div class="fixed inset-0 z-50" role="dialog" aria-modal="true">
            <button type="button" wire:click="closeDrawer" class="absolute inset-0 bg-slate-950/40" aria-label="Close user form"></button>
            <aside class="absolute inset-y-0 right-0 w-full max-w-lg overflow-y-auto bg-white shadow-2xl">
                <div class="flex items-start justify-between border-b border-hairline px-6 py-5"><div><h2 class="text-lg font-bold text-ink">{{ $editingId ? 'Edit user' : 'Add user' }}</h2><p class="mt-1 text-xs text-ink-muted">Account information and role-based access.</p></div><button type="button" wire:click="closeDrawer" class="grid size-9 place-items-center rounded-lg text-ink-muted hover:bg-slate-100" aria-label="Close">×</button></div>
                <form wire:submit="save" class="grid gap-5 p-6">
                    <x-sysadmin::input label="Name" name="name" wire:model="name" required />
                    <x-sysadmin::input label="Email address" name="email" type="email" wire:model="email" required />
                    <x-sysadmin::input label="Phone" name="phone" wire:model="phone" hint="Optional contact number for this administrator." />
                    <x-sysadmin::select label="Role" name="role" wire:model="role" placeholder="Select a role" required>@foreach($roles as $availableRole)<option value="{{ $availableRole->name }}">{{ str($availableRole->name)->replace(['-', '_'], ' ')->title() }}</option>@endforeach</x-sysadmin::select>
                    <div class="grid gap-4 sm:grid-cols-2"><x-sysadmin::input :label="$editingId ? 'New password' : 'Password'" name="password" type="password" wire:model="password" :hint="$editingId ? 'Leave blank to retain the current password.' : 'Minimum 8 characters.'" :required="!$editingId" /><x-sysadmin::input label="Confirm password" name="passwordConfirmation" type="password" wire:model="passwordConfirmation" :required="!$editingId" /></div>
                    <label class="flex cursor-pointer items-center justify-between rounded-xl border border-hairline p-4"><span><strong class="block text-[13px] text-ink">Active account</strong><small class="text-[11px] text-ink-muted">Inactive accounts cannot sign in.</small></span><input type="checkbox" wire:model="isActive" class="size-4 rounded border-hairline-strong text-primary"></label>
                    <div class="mt-2 flex justify-end gap-2 border-t border-hairline pt-5"><x-sysadmin::btn wire:click="closeDrawer">Cancel</x-sysadmin::btn><x-sysadmin::btn type="submit" variant="primary" wire:loading.attr="disabled"><span wire:loading.remove wire:target="save">Save user</span><span wire:loading wire:target="save">Saving…</span></x-sysadmin::btn></div>
                </form>
            </aside>
        </div>
    @endif

    @if($confirmingDelete)
        <div class="fixed inset-0 z-50 grid place-items-center bg-slate-950/40 p-4" role="dialog" aria-modal="true"><div class="w-full max-w-md rounded-xl bg-white p-6 shadow-2xl"><h2 class="text-lg font-bold text-ink">Delete user?</h2><p class="mt-2 text-[13px] text-ink-muted">This permanently removes the administrator account and its role assignments.</p><div class="mt-6 flex justify-end gap-2"><x-sysadmin::btn wire:click="$set('confirmingDelete', null)">Cancel</x-sysadmin::btn><x-sysadmin::btn variant="danger" wire:click="delete">Delete user</x-sysadmin::btn></div></div></div>
    @endif
</div>
