@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/select2.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Create Attribute</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Attributes</li>
    <li class="breadcrumb-item active">Create</li>
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
                    <form class="theme-form" id="create-attribute" method="POST"
                        action="{{ route('sysadmin.catalog.attribute.store') }}">
                        @csrf

                        <div class="card-body p-3">

                            {{-- Name --}}
                            <div class="row mb-3">
                                <label for="name" class="col-md-12 col-form-label">Attribute Name</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" placeholder="e.g., Color"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="off">
                                    @error('name')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Group --}}
                            <div class="row mb-3">
                                <label for="group_id" class="col-md-12 col-form-label">Attribute Group</label>
                                <div class="col-md-12">
                                    <select id="group_id" name="group_id"
                                        class="form-select select2 @error('group_id') is-invalid @enderror" required>
                                        <option value="">Select Group</option>
                                        @foreach ($groups as $k => $v)
                                            <option value="{{ $k }}"
                                                {{ (string) $k === (string) old('group_id') ? 'selected' : '' }}>
                                                {{ $v }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('group_id')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Type --}}
                            <div class="row mb-3">
                                <label for="type" class="col-md-12 col-form-label">Attribute Type</label>
                                <div class="col-md-12">
                                    <select id="type" name="type"
                                        class="form-select select2 @error('type') is-invalid @enderror" required>
                                        <option value="">Select Type</option>
                                        @foreach ($types as $k => $v)
                                            <option value="{{ $k }}"
                                                {{ (string) $k === (string) old('type') ? 'selected' : '' }}>
                                                {{ $v }}
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
                                        value="{{ old('sort_order', 0) }}">
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
                                            {{ old('comparable') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="comparable">Enable product comparison for this
                                            attribute</label>
                                        @error('comparable')
                                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Filterable</label>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input @error('filterable') is-invalid @enderror"
                                            type="checkbox" role="switch" id="filterable" name="filterable" value="1"
                                            {{ old('filterable') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filterable">Enable product filter for this
                                            attribute</label>
                                        @error('filterable')
                                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Configurable</label>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input @error('configurable') is-invalid @enderror"
                                            type="checkbox" role="switch" id="configurable" name="configurable"
                                            value="1" {{ old('configurable') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="configurable">Enable product filter for this
                                            attribute</label>
                                        @error('configurable')
                                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Require (required/optional) --}}
                            <div class="row mb-3">
                                <label for="require" class="col-md-12 col-form-label">Input Requirement</label>
                                <div class="col-md-12">
                                    <select id="require" name="require"
                                        class="form-select @error('require') is-invalid @enderror" required>
                                        @php
                                            $reqVal = old('require', 'required'); // default to 'required'
                                        @endphp
                                        <option value="1" {{ $reqVal === 'required' ? 'selected' : '' }}>Required
                                        </option>
                                        <option value="0" {{ $reqVal === 'optional' ? 'selected' : '' }}>Optional
                                        </option>
                                    </select>
                                    @error('require')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 d-none" id="attribute-values-wrapper">
                                <label class="col-md-12 col-form-label">Attribute Values</label>
                                <div class="col-md-12">
                                    <div id="attribute-values-list">

                                        @php
                                            $oldValues = old('values', ['']); // at least one row
                                        @endphp

                                        @foreach ($oldValues as $idx => $val)
                                            <div class="input-group mb-2 attribute-value-row">
                                                <input type="text" name="values[]" class="form-control"
                                                    placeholder="e.g., Red, Blue, Small, Large"
                                                    value="{{ $val }}">
                                                <button type="button"
                                                    class="btn btn-outline-danger remove-attribute-value">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        id="add-attribute-value">
                                        + Add Value
                                    </button>

                                    <small class="text-muted d-block mt-1">
                                        These options will be used for select / checkbox attributes (e.g., Color options:
                                        Red, Blue, Green).
                                    </small>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <a href="javascript:void(0);" id="cancel-button" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Submit</button>
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
                                form="create-attribute" id="status" required>
                                <option value="">Select one</option>
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ (string) $key === (string) old('status', 1) ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- (Optional) Helper note card --}}
                <div class="card">
                    <div class="card-header p-3">
                        <label class="col-md-12 col-form-label">Notes</label>
                    </div>
                    <div class="card-body p-3">
                        <p class="mb-0 small text-muted">
                            <strong>Type</strong> decides how this attribute is rendered (e.g., Text, Select, Multi-Select,
                            Boolean).<br>
                            <strong>Comparable</strong> enables this attribute in product comparison tables.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@pushOnce('scripts')
    <script type="module" src="{{ asset('admin/js/select2/select2.full.min.js') }}"></script>
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\AttributeFormRequest', '#create-attribute') !!}
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
    <script type="module" src="{{ asset('admin/js/select2/select2.full.min.js') }}"></script>
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\AttributeFormRequest', '#create-attribute') !!}
    <script type="module">
        // Init Select2
        $('.select2').select2({ width: '100%' });

        // Cancel -> index
        $('a#cancel-button').on('click', function () {
            window.location.href = "{{ route('sysadmin.catalog.attribute.index') }}";
        });

        /**
         * Show/hide Attribute Values section based on type text
         * Assuming type options text contains words like 'Select', 'Checkbox'
         */
        function toggleAttributeValues() {
            const typeText = $('#type option:selected').text().toLowerCase();

            // adjust these keywords to match your AttributeType names
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

        // Initial on page load
        toggleAttributeValues();

        // Add/remove value rows
        $('#add-attribute-value').on('click', function () {
            const row = `
                <div class="input-group mb-2 attribute-value-row">
                    <input type="text" name="values[]" class="form-control" placeholder="e.g., Red, Blue, Small, Large">
                    <button type="button" class="btn btn-outline-danger remove-attribute-value">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            `;
            $('#attribute-values-list').append(row);
        });

        $(document).on('click', '.remove-attribute-value', function () {
            const rows = $('.attribute-value-row');
            if (rows.length > 1) {
                $(this).closest('.attribute-value-row').remove();
            } else {
                // clear last input instead of removing
                $(this).closest('.attribute-value-row').find('input').val('');
            }
        });
    </script>
@endsection
