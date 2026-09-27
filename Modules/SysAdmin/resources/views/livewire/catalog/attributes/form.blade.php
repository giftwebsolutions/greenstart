<form wire:submit="save" class="catalog-workspace" novalidate>
    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div>
            <a href="{{ route('sysadmin.catalog.attribute.index') }}" class="small text-decoration-none">← Attributes</a>
            <h4 class="mt-2 mb-1">{{ $attributeId ? 'Edit attribute' : 'Create attribute' }}</h4>
            <p class="text-muted mb-0">Define how this field behaves in product entry, filters, variants and comparisons.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('sysadmin.catalog.attribute.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">Save attribute</span>
                <span wire:loading wire:target="save">Saving…</span>
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please check the highlighted fields.</strong>
            <ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-1">Definition</h5>
                    <small class="text-muted">Customer-facing label and stable developer code.</small>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label" for="attribute-name">Label <span class="text-danger">*</span></label>
                            <input id="attribute-name" wire:model.live.blur="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Membrane size" autofocus>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-5">
                            <label class="form-label" for="attribute-code">Code <span class="text-danger">*</span></label>
                            <input id="attribute-code" wire:model="code" class="form-control font-monospace @error('code') is-invalid @enderror" placeholder="membrane_size">
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Used by imports, APIs and templates.</div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label" for="attribute-type">Input type <span class="text-danger">*</span></label>
                            <select id="attribute-type" wire:model.live="type" class="form-select @error('type') is-invalid @enderror">
                                <option value="">Choose input type</option>
                                @foreach ($types as $typeOption)
                                    <option value="{{ $typeOption->attribute_type_id }}">{{ $typeOption->type_name }}</option>
                                @endforeach
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="sort-order">Default position</label>
                            <input id="sort-order" type="number" min="0" wire:model="sortOrder" class="form-control @error('sortOrder') is-invalid @enderror">
                            @error('sortOrder')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            @if ($usesOptions)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <div><h5 class="mb-1">Options</h5><small class="text-muted">Order controls storefront and variant selectors.</small></div>
                        <button type="button" wire:click="addValue" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus me-1"></i>Add option</button>
                    </div>
                    <div class="card-body">
                        @error('values')<div class="alert alert-danger py-2">{{ $message }}</div>@enderror
                        <div class="vstack gap-2">
                            @foreach ($values as $index => $value)
                                <div class="input-group" wire:key="option-{{ $index }}-{{ $value['id'] ?? 'new' }}">
                                    <span class="input-group-text drag-handle" title="Option position"><i class="fa fa-grip-vertical"></i></span>
                                    <input wire:model="values.{{ $index }}.value" class="form-control @error('values.'.$index.'.value') is-invalid @enderror" placeholder="Option label">
                                    <button type="button" wire:click="moveValue({{ $index }}, 'up')" class="btn btn-outline-secondary" aria-label="Move up">↑</button>
                                    <button type="button" wire:click="moveValue({{ $index }}, 'down')" class="btn btn-outline-secondary" aria-label="Move down">↓</button>
                                    <button type="button" wire:click="removeValue({{ $index }})" class="btn btn-outline-danger" aria-label="Remove">×</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-1">Family assignment</h5>
                    <small class="text-muted">An attribute can be reused in multiple families. Final order is controlled in the family builder.</small>
                </div>
                <div class="card-body">
                    @forelse ($families as $family)
                        <fieldset class="family-choice mb-3">
                            <legend>{{ $family->name }}</legend>
                            <div class="row g-2">
                                @foreach ($family->groups as $group)
                                    <div class="col-md-6">
                                        <label class="form-check family-group-choice">
                                            <input wire:model="groupIds" class="form-check-input" type="checkbox" value="{{ $group->id }}">
                                            <span class="form-check-label">{{ $group->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                    @empty
                        <div class="text-muted">Create an attribute family before assigning this attribute.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm mb-4 sticky-xl-top" style="top: 1rem">
                <div class="card-header bg-white border-bottom py-3"><h5 class="mb-0">Behavior</h5></div>
                <div class="card-body vstack gap-3">
                    @foreach ([
                        ['isRequired', 'Required', 'Product editors must provide a value.'],
                        ['isFilterable', 'Filterable', 'Show this field in catalog filters.'],
                        ['isConfigurable', 'Configurable', 'Use options to generate product variants.'],
                        ['isComparable', 'Comparable', 'Show this field in product comparison.'],
                    ] as [$model, $label, $help])
                        <label class="behavior-switch">
                            <span><strong>{{ $label }}</strong><small>{{ $help }}</small></span>
                            <input type="checkbox" class="form-check-input" role="switch" wire:model="{{ $model }}">
                        </label>
                        @error($model)<div class="text-danger small mt-n2">{{ $message }}</div>@enderror
                    @endforeach
                </div>
                <div class="card-footer bg-white">
                    <label class="form-label" for="attribute-status">Status</label>
                    <select id="attribute-status" wire:model="status" class="form-select">
                        <option value="1">Published</option>
                        <option value="2">Draft</option>
                        <option value="0">Disabled</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
