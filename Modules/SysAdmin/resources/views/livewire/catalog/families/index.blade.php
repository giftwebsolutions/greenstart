<div class="catalog-workspace">
    @include('sysadmin::layouts.alert')
    @error('delete')<div class="alert alert-danger">{{ $message }}</div>@enderror

    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div><h4 class="mb-1">Attribute families</h4><p class="text-muted mb-0">Product templates containing ordered groups and reusable attributes.</p></div>
        <a href="{{ route('sysadmin.catalog.attribute.family.create') }}" class="btn btn-primary"><i class="fa fa-plus me-1"></i>New family</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body border-bottom">
            <div class="row g-2">
                <div class="col-md-8"><input type="search" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search family name or code"></div>
                <div class="col-md-4"><select wire:model.live="status" class="form-select"><option value="all">All statuses</option><option value="1">Published</option><option value="2">Draft</option><option value="0">Disabled</option></select></div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 catalog-table">
                <thead><tr><th>Family</th><th>Structure</th><th>Products</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse ($families as $family)
                        <tr wire:key="family-{{ $family->id }}">
                            <td><div class="fw-semibold">{{ $family->name }}</div><code class="small">{{ $family->code }}</code></td>
                            <td><strong>{{ $family->groups_count }}</strong> groups <span class="text-muted mx-1">·</span> <strong>{{ $family->attributes_count }}</strong> attributes</td>
                            <td>{{ $family->products_count }}</td>
                            <td><span class="status-dot status-{{ $family->status }}"></span>{{ [0 => 'Disabled', 1 => 'Published', 2 => 'Draft'][$family->status] }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('sysadmin.catalog.attribute.family.edit', $family->id) }}" class="btn btn-sm btn-primary">Open builder</a>
                                <button type="button" wire:click="delete({{ $family->id }})" wire:confirm="Delete this family and its groups?" class="btn btn-sm btn-outline-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-5">No attribute families found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($families->hasPages())<div class="card-footer bg-white">{{ $families->links() }}</div>@endif
    </div>
</div>
