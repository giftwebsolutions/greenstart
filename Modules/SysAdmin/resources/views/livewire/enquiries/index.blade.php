<div class="grid gap-5">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div><p class="text-xs font-bold uppercase tracking-[.12em] text-primary">Customer pipeline</p><h1 class="mt-1 text-[22px] font-bold tracking-tight text-ink">Enquiry CRM</h1><p class="mt-1 text-[13px] text-ink-muted">Track every request from first contact through follow-up and conversion.</p></div>
        <div class="flex flex-wrap gap-2"><x-sysadmin::btn :href="route('sysadmin.enquiry.appointments')">Appointments</x-sysadmin::btn>@can('customer.enquiries.create')<x-sysadmin::btn variant="primary" :href="route('sysadmin.enquiry.create')">{!! \Modules\SysAdmin\Support\Icon::get('plus', 'h-4 w-4') !!} New enquiry</x-sysadmin::btn>@endcan</div>
    </div>

    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['New enquiries', $stats['new'], 'Needs first contact', 'bg-blue-50 text-blue-700'],
            ['Overdue follow-ups', $stats['overdue'], 'Requires attention', 'bg-red-50 text-red-700'],
            ['Today appointments', $stats['appointments_today'], 'Scheduled today', 'bg-violet-50 text-violet-700'],
            ['Open pipeline', $stats['open'], 'Active opportunities', 'bg-emerald-50 text-emerald-700'],
        ] as [$label, $value, $hint, $classes])
            <x-sysadmin::card padded><div class="flex items-start justify-between"><div><p class="text-[11px] font-bold uppercase tracking-wide text-ink-muted">{{ $label }}</p><strong class="mt-2 block text-2xl font-bold text-ink">{{ number_format($value) }}</strong><span class="mt-1 block text-[11px] text-ink-muted">{{ $hint }}</span></div><span class="grid size-9 place-items-center rounded-lg {{ $classes }}">{!! \Modules\SysAdmin\Support\Icon::get('message', 'h-4 w-4') !!}</span></div></x-sysadmin::card>
        @endforeach
    </div>

    <x-sysadmin::table-toolbar search-placeholder="Search name, mobile, email, subject or city…">
        <select wire:model.live="status" class="min-h-11 rounded-xl border border-hairline-strong bg-white px-3 text-[12px] font-semibold text-ink"><option value="">All statuses</option>@foreach(\Modules\SysAdmin\Models\Enquiry::$statuses as $key => $label)<option value="{{ $key }}">{{ $label }}</option>@endforeach</select>
        <select wire:model.live="priority" class="min-h-11 rounded-xl border border-hairline-strong bg-white px-3 text-[12px] font-semibold text-ink"><option value="">All priorities</option>@foreach(\Modules\SysAdmin\Models\Enquiry::$priorities as $key => $label)<option value="{{ $key }}">{{ $label }}</option>@endforeach</select>
        <select wire:model.live="followUp" class="min-h-11 rounded-xl border border-hairline-strong bg-white px-3 text-[12px] font-semibold text-ink"><option value="">Any follow-up</option><option value="overdue">Overdue</option><option value="today">Due today</option><option value="upcoming">Upcoming</option><option value="none">No task</option></select>
        <select wire:model.live="assignedTo" class="min-h-11 rounded-xl border border-hairline-strong bg-white px-3 text-[12px] font-semibold text-ink"><option value="">All owners</option><option value="unassigned">Unassigned</option>@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->name }}</option>@endforeach</select>
    </x-sysadmin::table-toolbar>

    <div class="flex flex-wrap items-end gap-2 rounded-xl border border-hairline bg-white px-4 py-3 shadow-sm">
        <label class="grid gap-1 text-[11px] font-bold text-ink-muted">Created from<input wire:model.live="createdFrom" type="date" class="min-h-9 rounded-lg border border-hairline-strong px-2 text-xs text-ink"></label>
        <label class="grid gap-1 text-[11px] font-bold text-ink-muted">Created to<input wire:model.live="createdTo" type="date" class="min-h-9 rounded-lg border border-hairline-strong px-2 text-xs text-ink"></label>
        <label class="ml-auto grid gap-1 text-[11px] font-bold text-ink-muted">Rows<select wire:model.live="perPage" class="min-h-9 rounded-lg border border-hairline-strong px-2 text-xs text-ink"><option value="15">15</option><option value="30">30</option><option value="50">50</option></select></label>
        <button type="button" wire:click="clearFilters" class="min-h-9 rounded-lg px-3 text-xs font-semibold text-primary hover:bg-primary-50">Clear filters</button>
    </div>

    <div wire:loading.class="opacity-60" class="overflow-x-auto rounded-xl border border-hairline bg-white shadow-sm transition">
        <table class="w-full min-w-[1080px] border-collapse">
            <thead><tr><x-sysadmin::th>Customer</x-sysadmin::th><x-sysadmin::th>Request</x-sysadmin::th><x-sysadmin::th>Owner</x-sysadmin::th><x-sysadmin::th>Priority</x-sysadmin::th><x-sysadmin::th>Status</x-sysadmin::th><x-sysadmin::th>Next action</x-sysadmin::th><x-sysadmin::th>Received</x-sysadmin::th><x-sysadmin::th align="right">Actions</x-sysadmin::th></tr></thead>
            <tbody>
                @forelse($enquiries as $enquiry)
                    @php($next = $enquiry->latestPendingFollowUp)
                    <tr wire:key="enquiry-{{ $enquiry->id }}" class="hover:bg-[#fafbfc]">
                        <x-sysadmin::td><a href="{{ route('sysadmin.enquiry.view', $enquiry->id) }}" class="font-bold text-ink hover:text-primary">{{ $enquiry->name }}</a><span class="mt-0.5 block text-[11px] text-ink-muted">{{ $enquiry->mobile }}@if($enquiry->email) · {{ $enquiry->email }}@endif</span></x-sysadmin::td>
                        <x-sysadmin::td><span class="block max-w-52 truncate text-[12.5px] font-semibold text-ink-soft">{{ $enquiry->subject ?: 'General enquiry' }}</span><span class="mt-0.5 block max-w-52 truncate text-[11px] text-ink-muted">{{ $enquiry->product?->title ?: str($enquiry->message)->limit(48) }}</span></x-sysadmin::td>
                        <x-sysadmin::td><span class="text-[12px] text-ink-soft">{{ $enquiry->assignedUser?->name ?? 'Unassigned' }}</span></x-sysadmin::td>
                        <x-sysadmin::td><span @class(['inline-flex rounded-full px-2.5 py-1 text-[10.5px] font-bold', 'bg-red-50 text-red-700' => $enquiry->priority === 'urgent', 'bg-amber-50 text-amber-700' => $enquiry->priority === 'high', 'bg-blue-50 text-blue-700' => $enquiry->priority === 'normal', 'bg-slate-100 text-slate-600' => $enquiry->priority === 'low'])>{{ \Modules\SysAdmin\Models\Enquiry::$priorities[$enquiry->priority] ?? str($enquiry->priority)->headline() }}</span></x-sysadmin::td>
                        <x-sysadmin::td>@can('customer.enquiries.update')<select wire:change="updateStatus({{ $enquiry->id }}, $event.target.value)" class="min-h-8 rounded-lg border border-hairline-strong bg-white px-2 text-[11px] font-semibold text-ink">@foreach(\Modules\SysAdmin\Models\Enquiry::$statuses as $key => $label)<option value="{{ $key }}" @selected((int)$enquiry->status === $key)>{{ $label }}</option>@endforeach</select>@else<span class="inline-flex rounded-full px-2.5 py-1 text-[10.5px] font-bold {{ \Modules\SysAdmin\Models\Enquiry::statusClasses((int)$enquiry->status) }}">{{ \Modules\SysAdmin\Models\Enquiry::$statuses[(int)$enquiry->status] ?? $enquiry->status }}</span>@endcan</x-sysadmin::td>
                        <x-sysadmin::td>@if($next)<span class="block text-[11.5px] font-semibold {{ $next->scheduled_at->isPast() ? 'text-red-600' : 'text-ink-soft' }}">{{ $next->scheduled_at->format('d M, h:i A') }}</span><span class="block max-w-40 truncate text-[10.5px] text-ink-muted">{{ $next->subject }}</span>@else<span class="text-[11px] text-ink-muted">No task scheduled</span>@endif</x-sysadmin::td>
                        <x-sysadmin::td><span class="whitespace-nowrap text-[11.5px] text-ink-muted">{{ $enquiry->created_at?->format('d M Y') }}</span></x-sysadmin::td>
                        <x-sysadmin::td align="right"><div class="flex justify-end gap-1"><x-sysadmin::icon-button icon="eye" label="Open CRM workspace" :href="route('sysadmin.enquiry.view', $enquiry->id)" />@can('customer.enquiries.update')<x-sysadmin::icon-button icon="pencil" label="Edit enquiry" :href="route('sysadmin.enquiry.edit', $enquiry->id)" />@endcan</div></x-sysadmin::td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-6 py-14 text-center"><span class="mx-auto grid size-11 place-items-center rounded-full bg-slate-100 text-ink-muted">{!! \Modules\SysAdmin\Support\Icon::get('search') !!}</span><strong class="mt-3 block text-[13px] text-ink">No enquiries found</strong><span class="mt-1 block text-xs text-ink-muted">Change the filters or add a new enquiry.</span></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($enquiries->hasPages())<div>{{ $enquiries->links() }}</div>@endif
</div>
