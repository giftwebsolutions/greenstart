<div class="catalog-workspace">
    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div><h4 class="mb-1">{{ $definition['title'] }}</h4><p class="text-muted mb-0">{{ $definition['description'] }}</p></div>
        @if ($definition['create'])<a href="{{ route($definition['create']) }}" class="btn btn-primary"><i class="fa fa-plus me-1"></i>New</a>@endif
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body border-bottom">
            <div class="row g-2"><div class="col-lg-8"><div class="input-group"><span class="input-group-text bg-white"><i class="fa fa-search"></i></span><input wire:model.live.debounce.300ms="search" type="search" class="form-control" placeholder="Search {{ strtolower($definition['title']) }}"></div></div><div class="col-lg-4"><select wire:model.live="perPage" class="form-select"><option value="15">15 per page</option><option value="30">30 per page</option><option value="50">50 per page</option></select></div></div>
        </div>
        <div class="table-responsive">
            <table id="{{ $resource }}-table" class="table align-middle mb-0 catalog-table">
                <thead><tr>@foreach ($definition['columns'] as $column)<th>@if ($column['sort'] ?? null)<button type="button" wire:click="sort('{{ $column['sort'] }}')" class="table-sort">{{ $column['label'] }} @if ($sortField === $column['sort']){{ $sortDirection === 'asc' ? '↑' : '↓' }}@endif</button>@else{{ $column['label'] }}@endif</th>@endforeach<th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse ($rows as $row)
                        <tr wire:key="{{ $resource }}-{{ $row->getKey() }}">
                            @foreach ($definition['columns'] as $column)
                                @php($value = data_get($row, $column['key']))
                                <td>
                                    @switch($column['type'] ?? null)
                                        @case('status')<span class="status-dot status-{{ (int) $value }}"></span>{{ [0 => 'Disabled', 1 => 'Published', 2 => 'Draft'][(int) $value] ?? $value }}@break
                                        @case('date'){{ $value instanceof \DateTimeInterface ? $value->format('d M Y, H:i') : ($value ?: '—') }}@break
                                        @case('truncate'){{ \Illuminate\Support\Str::limit(strip_tags((string) $value), 80) }}@break
                                        @default{{ filled($value) ? $value : '—' }}
                                    @endswitch
                                </td>
                            @endforeach
                            <td class="text-end text-nowrap">
                                @if ($definition['view'])<a href="{{ route($definition['view'], $row->getKey()) }}" class="btn btn-sm btn-outline-secondary">View</a>@endif
                                @if ($definition['edit'])<a href="{{ route($definition['edit'], $row->getKey()) }}" class="btn btn-sm btn-outline-primary">Edit</a>@endif
                                @if ($definition['delete'])
                                    <form method="POST" action="{{ route($definition['delete'], $row->getKey()) }}" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ count($definition['columns']) + 1 }}" class="py-5 text-center text-muted">No records match your search.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($rows->hasPages())<div class="card-footer bg-white">{{ $rows->links() }}</div>@endif
    </div>
</div>
