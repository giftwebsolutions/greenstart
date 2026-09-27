<div class="catalog-workspace">
    @include('sysadmin::layouts.alert')

    @error('delete')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div>
            <h4 class="mb-1">Product attributes</h4>
            <p class="text-muted mb-0">Reusable field definitions shared across attribute families.</p>
        </div>
        <a href="{{ route('sysadmin.catalog.attribute.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> New attribute
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body border-bottom">
            <div class="row g-2">
                <div class="col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fa fa-search"></i></span>
                        <input wire:model.live.debounce.300ms="search" type="search" class="form-control" placeholder="Search label or code">
                    </div>
                </div>
                <div class="col-sm-4 col-lg-3">
                    <select wire:model.live="family" class="form-select" aria-label="Filter by family">
                        <option value="all">All families</option>
                        @foreach ($families as $familyOption)
                            <option value="{{ $familyOption->id }}">{{ $familyOption->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 col-lg-2">
                    <select wire:model.live="usage" class="form-select" aria-label="Filter by usage">
                        <option value="all">All uses</option>
                        <option value="filterable">Filterable</option>
                        <option value="configurable">Configurable</option>
                        <option value="comparable">Comparable</option>
                    </select>
                </div>
                <div class="col-sm-4 col-lg-2">
                    <select wire:model.live="status" class="form-select" aria-label="Filter by status">
                        <option value="all">All statuses</option>
                        <option value="1">Published</option>
                        <option value="2">Draft</option>
                        <option value="0">Disabled</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 catalog-table">
                <thead>
                    <tr>
                        <th><button wire:click="sort('name')" class="table-sort">Attribute</button></th>
                        <th>Type</th>
                        <th>Families / groups</th>
                        <th>Usage</th>
                        <th><button wire:click="sort('status')" class="table-sort">Status</button></th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attributeRows as $attribute)
                        <tr wire:key="attribute-{{ $attribute->id }}">
                            <td>
                                <div class="fw-semibold text-dark">{{ $attribute->name }}</div>
                                <code class="small">{{ $attribute->code }}</code>
                            </td>
                            <td>{{ $attribute->attribute_type?->type_name ?? 'Unknown' }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse ($attribute->groups as $group)
                                        <span class="badge rounded-pill text-bg-light border">{{ $group->family?->name }} · {{ $group->name }}</span>
                                    @empty
                                        <span class="text-muted">Unassigned</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @if ($attribute->require)<span class="badge text-bg-danger-subtle text-danger-emphasis">Required</span>@endif
                                    @if ($attribute->filterable)<span class="badge text-bg-info-subtle text-info-emphasis">Filter</span>@endif
                                    @if ($attribute->configurable)<span class="badge text-bg-primary-subtle text-primary-emphasis">Variant</span>@endif
                                    @if ($attribute->comparable)<span class="badge text-bg-secondary-subtle text-secondary-emphasis">Compare</span>@endif
                                </div>
                            </td>
                            <td>
                                <span class="status-dot status-{{ $attribute->status }}"></span>
                                {{ [0 => 'Disabled', 1 => 'Published', 2 => 'Draft'][$attribute->status] ?? 'Unknown' }}
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('sysadmin.catalog.attribute.edit', $attribute->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <button type="button" wire:click="delete({{ $attribute->id }})" wire:confirm="Delete this attribute?" class="btn btn-sm btn-outline-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-5 text-center text-muted">No attributes match these filters.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($attributeRows->hasPages())
            <div class="card-footer bg-white">{{ $attributeRows->links() }}</div>
        @endif
    </div>
</div>
