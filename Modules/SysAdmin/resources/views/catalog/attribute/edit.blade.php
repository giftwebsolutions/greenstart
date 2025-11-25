@php
    //dd($attribute->group_id, $groups, $attribute->type, $types);
@endphp
@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/select2.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Edit Attribute</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Attributes</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <div class="col-md-8">
                <div class="card">
                    <form class="theme-form" id="update-attribute" method="POST"
                        action="{{ route('sysadmin.catalog.attribute.update', $attribute->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="card-body p-3">

                            {{-- Name --}}
                            <div class="row mb-3">
                                <label for="name" class="col-md-12 col-form-label">Attribute Name</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" placeholder="e.g., Color"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $attribute->name) }}" required autocomplete="off">
                                    @error('name')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Attribute Group --}}
                            <div class="row mb-3">
                                <label for="group_id" class="col-md-12 col-form-label">Attribute Group</label>
                                <div class="col-md-12">
                                    <select id="group_id" name="group_id"
                                        class="form-select select2 @error('group_id') is-invalid @enderror" required>
                                        <option value="">Select Group</option>
                                        @foreach ($groups as $gid => $gname)
                                            <option value="{{ $gid }}"
                                                {{ (int) old('group_id', $attribute->group_id) === (int) $gid ? 'selected' : '' }}>
                                                {{ $gname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('group_id')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Attribute Type --}}
                            <div class="row mb-3">
                                <label for="type" class="col-md-12 col-form-label">Attribute Type</label>
                                <div class="col-md-12">
                                    <select id="type" name="type"
                                        class="form-select select2 @error('type') is-invalid @enderror" required>
                                        <option value="">Select Type</option>
                                        @foreach ($types as $tid => $tname)
                                            <option value="{{ $tid }}"
                                                {{ (int) old('type', $attribute->type) === (int) $tid ? 'selected' : '' }}>
                                                {{ $tname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Sort Order --}}
                            <div class="row mb-3">
                                <label for="sort_order" class="col-md-12 col-form-label">Sort Order</label>
                                <div class="col-md-12">
                                    <input id="sort_order" type="number" min="0" step="1"
                                        class="form-control @error('sort_order') is-invalid @enderror" name="sort_order"
                                        value="{{ old('sort_order', $attribute->sort_order ?? 0) }}">
                                    @error('sort_order')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Comparable --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Comparable</label>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input @error('comparable') is-invalid @enderror"
                                            type="checkbox" role="switch" id="comparable" name="comparable" value="1"
                                            {{ old('comparable', $attribute->comparable) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="comparable">
                                            Enable product comparison for this attribute
                                        </label>
                                        @error('comparable')
                                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Configurable --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Configurable</label>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input @error('configurable') is-invalid @enderror"
                                            type="checkbox" role="switch" id="configurable" name="configurable"
                                            value="1"
                                            {{ old('configurable', $attribute->configurable) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="configurable">
                                            Enable product configurable for this attribute
                                        </label>
                                        @error('configurable')
                                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Filterable --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Filterable</label>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input @error('filterable') is-invalid @enderror"
                                            type="checkbox" role="switch" id="filterable" name="filterable"
                                            value="1"
                                            {{ old('filterable', $attribute->filterable) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filterable">
                                            Enable product filterable for this attribute
                                        </label>
                                        @error('filterable')
                                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Require --}}
                            <div class="row mb-3">
                                <label for="require" class="col-md-12 col-form-label">Input Requirement</label>
                                <div class="col-md-12">
                                    @php $reqVal = old('require', $attribute->require ?? '1'); @endphp
                                    <select id="require" name="require"
                                        class="form-select @error('require') is-invalid @enderror" required>
                                        <option value="1" {{ (string) $reqVal === '1' ? 'selected' : '' }}>Required
                                        </option>
                                        <option value="0" {{ (string) $reqVal === '0' ? 'selected' : '' }}>Optional
                                        </option>
                                    </select>
                                    @error('require')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Attribute Values (for select / checkbox types) --}}
                            <div class="row mb-3 d-none" id="attribute-values-wrapper">
                                <label class="col-md-12 col-form-label">Attribute Values</label>

                                <div class="col-md-12">
                                    <div id="attribute-values-list">

                                        @php
                                            // Values from controller: [['id' => 1, 'value' => 'Red'], ...]
                                            $dbValues = $values ?? [];

                                            // Normalize (if strings somehow slip through)
                                            $dbValues = array_map(function ($v) {
                                                return is_array($v) ? $v : ['id' => null, 'value' => $v];
                                            }, $dbValues);

                                            // Old input (after validation error) has priority
                                            $oldValues = old('values', $dbValues);

                                            if (empty($oldValues)) {
                                                $oldValues = [['id' => null, 'value' => '']];
                                            }
                                        @endphp

                                        @foreach ($oldValues as $idx => $val)
                                            <div class="input-group mb-2 attribute-value-row">

                                                {{-- hidden ID (existing value or null for new) --}}
                                                <input type="hidden" name="values[{{ $idx }}][id]"
                                                    value="{{ $val['id'] ?? '' }}">

                                                {{-- value text --}}
                                                <input type="text" name="values[{{ $idx }}][value]"
                                                    class="form-control" placeholder="e.g., Red, Blue, Small, Large"
                                                    value="{{ $val['value'] ?? '' }}">

                                                <button type="button"
                                                    class="btn btn-outline-danger remove-attribute-value">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach

                                    </div>

                                    {{-- Add row button --}}
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        id="add-attribute-value">
                                        + Add Value
                                    </button>

                                    <small class="text-muted d-block mt-1">
                                        These options will be used for select / checkbox field types.
                                    </small>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <a href="javascript:void(0);" id="cancel-button" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar: Status --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header p-3">
                        <label class="col-md-12 col-form-label">Status</label>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" form="update-attribute" required>
                                <option value="">Select one</option>
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ (string) old('status', $attribute->status) === (string) $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <p class="small text-muted mb-0">
                            <strong>Type</strong> controls input widget (Text/Select/Multi/Boolean).<br>
                            <strong>Comparable</strong> shows this attribute in comparison tables.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@pushOnce('scripts')
    <script type="module" src="{{ asset('admin/js/select2/select2.full.min.js') }}"></script>
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\AttributeFormRequest', '#update-attribute') !!}
    <script type="module">
        // Init Select2
        $('.select2').select2({
            width: '100%'
        });

        // Cancel -> index
        $('a#cancel-button').on('click', function() {
            window.location.href = "{{ route('sysadmin.catalog.attribute.index') }}";
        });
    </script>
@endPushOnce

@section('script')
    <script type="module">
        // Show/hide based on attribute type
        function toggleAttributeValues() {
            const typeText = $('#type option:selected').text().toLowerCase();

            const needsValues =
                typeText.includes('select') ||
                typeText.includes('checkbox') ||
                typeText.includes('multi');

            if (needsValues) {
                $('#attribute-values-wrapper').removeClass('d-none');
            } else {
                $('#attribute-values-wrapper').addClass('d-none');
            }
        }

        $('#type').on('change', toggleAttributeValues);
        toggleAttributeValues(); // initial load

        // Add new value row
        $('#add-attribute-value').on('click', function() {
            const index = $('.attribute-value-row').length;
            const row = `
                <div class="input-group mb-2 attribute-value-row">
                    <input type="hidden" name="values[${index}][id]" value="">
                    <input type="text" name="values[${index}][value]" class="form-control" placeholder="e.g., Red, Blue">
                    <button type="button" class="btn btn-outline-danger remove-attribute-value">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            `;
            $('#attribute-values-list').append(row);
        });

        // Remove value row
        $(document).on('click', '.remove-attribute-value', function() {
            const rows = $('.attribute-value-row');
            if (rows.length > 1) {
                $(this).closest('.attribute-value-row').remove();
            } else {
                $(this).closest('.attribute-value-row').find('input[type="text"]').val('');
                $(this).closest('.attribute-value-row').find('input[type="hidden"]').val('');
            }
        });
    </script>
@endsection
