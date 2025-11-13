@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Edit Attribute Group</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Attributes</li>
    <li class="breadcrumb-item active">Groups</li>
@endsection

@section('content')
<div class="container-fluid">
    @if ($errors->any())
        <div class="alert alert-secondary alert-dismissible fade show">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Left: Main form --}}
        <div class="col-md-8">
            <div class="card">
                <form id="update-attribute-group" class="theme-form" method="POST"
                      action="{{ route('sysadmin.catalog.attribute.group.update', $group->id) }}">
                    @csrf @method('PATCH')

                    <div class="card-body p-3">

                        {{-- Group Name --}}
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Group Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $group->name) }}"
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        {{-- Slug --}}
                        <div class="mb-3">
                            <label for="slug" class="col-form-label">
                                Slug <small class="text-muted">(optional)</small>
                            </label>
                            <input id="slug" type="text" name="slug" value="{{ old('slug', $group->slug) }}"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   placeholder="auto if empty">
                            @error('slug') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        {{-- Attributes (checkbox + optional value) --}}
                        <div class="mb-3">
                            <label class="col-form-label">Select Attributes</label>

                            @php
                                // For fast lookups of existing selections and values
                                $selectedIds = isset($group) ? $group->attributes->pluck('id')->all() : [];
                                $pivotValues = isset($group)
                                    ? $group->attributes->mapWithKeys(fn($a)=>[$a->id => $a->pivot->value])->all()
                                    : [];
                                $oldSelected = old('attributes', []);
                                $oldValues   = old('attribute_values', []);
                            @endphp

                            @if(isset($attributes) && $attributes->count())
                                <div class="row">
                                    @foreach($attributes as $attr)
                                        @php
                                            $checked = $oldSelected
                                                ? in_array($attr->id, $oldSelected)
                                                : in_array($attr->id, $selectedIds);

                                            $currentValue = $oldValues
                                                ? ($oldValues[$attr->id] ?? '')
                                                : ($pivotValues[$attr->id] ?? '');
                                        @endphp

                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       id="attr_{{ $attr->id }}"
                                                       name="attributes[]"
                                                       value="{{ $attr->id }}"
                                                       @checked($checked)>
                                                <label for="attr_{{ $attr->id }}" class="form-check-label">
                                                    {{ $attr->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">No attributes found. Please create attributes first.</p>
                            @endif

                            @error('attributes')<div class="text-danger small">{{ $message }}</div>@enderror
                            @error('attributes.*')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('sysadmin.catalog.attribute.group.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary mx-2">Update</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right: Status --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header p-3">
                    <label class="col-form-label">Status</label>
                </div>
                <div class="card-body p-3">
                    <select class="form-select @error('status') is-invalid @enderror"
                            name="status" form="update-attribute-group" required>
                        <option value="">Select one</option>
                        @foreach($statuses as $k => $v)
                            <option value="{{ $k }}"
                                {{ (string)old('status', $group->status) === (string)$k ? 'selected' : '' }}>
                                {{ $v }}
                            </option>
                        @endforeach
                    </select>
                    @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\AttributeGroupFormRequest', '#update-attribute-group') !!}
@endPushOnce
