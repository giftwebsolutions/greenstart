<div class="grid gap-5">
    @php
        $createPermission = \Modules\SysAdmin\Support\PermissionCatalog::forRoute($definition['create'] ?? null);
        $canCreate = ! $createPermission || auth()->user()?->can($createPermission);
    @endphp
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div><h1 class="text-[22px] font-bold tracking-tight text-ink">{{ $definition['title'] }}</h1><p class="mt-1 text-[13px] text-ink-muted">{{ $definition['description'] }}</p></div>
        @if($definition['create'] && $canCreate)<x-sysadmin::btn variant="primary" :href="route($definition['create'])">{!! \Modules\SysAdmin\Support\Icon::get('plus', 'h-4 w-4') !!} New {{ str($definition['title'])->singular()->lower() }}</x-sysadmin::btn>@endif
    </div>

    <x-sysadmin::table-toolbar search-placeholder="Search {{ strtolower($definition['title']) }}...">
        <select wire:model.live="perPage" class="min-h-11 rounded-xl border border-hairline-strong bg-white px-3 text-[12.5px] font-semibold text-ink focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50" aria-label="Rows per page"><option value="15">15 rows</option><option value="30">30 rows</option><option value="50">50 rows</option></select>
    </x-sysadmin::table-toolbar>

    <div wire:loading.class="opacity-60" class="overflow-x-auto rounded-xl border border-hairline bg-white shadow-sm transition">
        <table id="{{ $resource }}-table" class="w-full min-w-[760px] border-collapse">
            <thead><tr>@foreach($definition['columns'] as $column)<x-sysadmin::th>@if($column['sort'] ?? null)<button type="button" wire:click="sort('{{ $column['sort'] }}')" class="inline-flex items-center gap-1.5 hover:text-primary">{{ $column['label'] }} {!! \Modules\SysAdmin\Support\Icon::get('sort', 'h-3.5 w-3.5') !!}@if($sortField === $column['sort'])<span class="text-primary">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@endif</button>@else{{ $column['label'] }}@endif</x-sysadmin::th>@endforeach<x-sysadmin::th align="right">Actions</x-sysadmin::th></tr></thead>
            <tbody>
            @forelse($rows as $row)
                @php
                    $viewPermission = \Modules\SysAdmin\Support\PermissionCatalog::forRoute($definition['view'] ?? null);
                    $editPermission = \Modules\SysAdmin\Support\PermissionCatalog::forRoute($definition['edit'] ?? null);
                    $deletePermission = \Modules\SysAdmin\Support\PermissionCatalog::forRoute($definition['delete'] ?? null);
                    $canView = ! $viewPermission || auth()->user()?->can($viewPermission);
                    $canEdit = ! $editPermission || auth()->user()?->can($editPermission);
                    $canDelete = ! $deletePermission || auth()->user()?->can($deletePermission);
                @endphp
                <tr wire:key="{{ $resource }}-{{ $row->getKey() }}" class="hover:bg-[#fafbfc]">
                    @foreach($definition['columns'] as $column)
                        @php($value = data_get($row, $column['key']))
                        <x-sysadmin::td>
                            @switch($column['type'] ?? null)
                                @case('status')<span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11.5px] font-semibold {{ (int)$value === 1 ? 'bg-emerald-50 text-emerald-700' : ((int)$value === 2 ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600') }}"><span class="size-1.5 rounded-full bg-current"></span>{{ [0 => 'Disabled', 1 => 'Published', 2 => 'Draft'][(int)$value] ?? $value }}</span>@break
                                @case('date')<span class="whitespace-nowrap text-[12.5px] text-ink-soft">{{ $value instanceof \DateTimeInterface ? $value->format('d M Y, H:i') : ($value ?: '—') }}</span>@break
                                @case('truncate')<span class="text-ink-soft">{{ \Illuminate\Support\Str::limit(strip_tags((string)$value), 80) }}</span>@break
                                @default<span class="text-[13px] {{ $loop->parent->first ? 'font-semibold text-ink' : 'text-ink-soft' }}">{{ filled($value) ? $value : '—' }}</span>
                            @endswitch
                        </x-sysadmin::td>
                    @endforeach
                    <x-sysadmin::td align="right"><div class="flex justify-end gap-1">
                        @if($definition['view'] && $canView)<x-sysadmin::icon-button icon="eye" label="View" :href="route($definition['view'], $row->getKey())" />@endif
                        @if($definition['edit'] && $canEdit)<x-sysadmin::icon-button icon="pencil" label="Edit" :href="route($definition['edit'], $row->getKey())" />@endif
                        @if($definition['delete'] && $canDelete)<form method="POST" action="{{ route($definition['delete'], $row->getKey()) }}" onsubmit="return confirm('Delete this record?')">@csrf @method('DELETE')<x-sysadmin::icon-button icon="trash" label="Delete" danger type="submit" /></form>@endif
                    </div></x-sysadmin::td>
                </tr>
            @empty
                <tr><td colspan="{{ count($definition['columns']) + 1 }}" class="px-6 py-14 text-center"><span class="mx-auto grid size-11 place-items-center rounded-full bg-slate-100 text-ink-muted">{!! \Modules\SysAdmin\Support\Icon::get('search') !!}</span><p class="mt-3 text-[13px] font-semibold text-ink">No records found</p><p class="mt-1 text-xs text-ink-muted">Try a different search term.</p></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($rows->hasPages())<div>{{ $rows->links() }}</div>@endif
</div>
