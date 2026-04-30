@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/select2.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Create Product</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Products</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="container-fluid">
        <form id="create-product"
              class="theme-form"
              method="POST"
              enctype="multipart/form-data"
              action="{{ route('sysadmin.catalog.product.store') }}">
            @csrf

            <div class="row">

                {{-- Error Handling --}}
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>

                {{-- LEFT PANEL --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body p-3">

                            {{-- Title --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Product Title <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Product Code</label>
                                <div class="col-md-12">
                                    <input type="text" name="product_code" id="product_code" class="form-control" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Model No</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" value="" name="model" id="model">
                                </div>
                            </div>

                            {{-- Keywords --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Keywords</label>
                                <div class="col-md-12">
                                    <input type="text" name="keywords" class="form-control" value="{{ old('keywords') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Short Description</label>
                                <div class="col-md-12">
                                    <textarea name="short_description" class="form-control" rows="3">{{ old('short_description') }}</textarea>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Description</label>
                                <div class="col-md-12">
                                    <textarea name="description" class="form-control" rows="8">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            {{-- SKU --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">SKU</label>
                                <div class="col-md-12">
                                    <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                                    <small class="text-muted">For variable products, variant SKUs are mandatory. Parent SKU is optional.</small>
                                </div>
                            </div>

                            {{-- Product Type (AUTO) --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Product Type</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" value="Auto (based on Attribute Set)" readonly>
                                    <small class="text-muted">
                                        Type will be determined automatically after selecting Attribute Set (Configurable attributes → Variants).
                                    </small>
                                </div>
                            </div>

                            {{-- Video --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Video URL</label>
                                <div class="col-md-12">
                                    <input type="text" name="video" class="form-control" value="{{ old('video') }}">
                                </div>
                            </div>

                            {{-- Catalog --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Catalog URL</label>
                                <div class="col-md-12">
                                    <input type="text" name="catalog" class="form-control" value="{{ old('catalog') }}">
                                </div>
                            </div>

                            {{-- Thumb Image --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Thumbnail Image</label>
                                <div class="col-md-12">
                                    <input type="file" name="thumb" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp">
                                    <small class="text-muted">Used as base image fallback. Variants can have their own image later.</small>
                                </div>
                            </div>

                            {{-- Gallery Images (NEW) --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Product Gallery Images</label>
                                <div class="col-md-12">
                                    <input type="file" name="gallery_images[]" class="form-control" multiple
                                           accept=".jpg,.jpeg,.png,.gif,.webp">
                                    <small class="text-muted">Upload multiple images (optional). Used after variant image in priority.</small>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('sysadmin.catalog.product.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Submit</button>
                        </div>
                    </div>
                </div>

                {{-- RIGHT PANEL --}}
                <div class="col-md-4">

                    {{-- MRP --}}
                    <div class="card">
                        <div class="card-header p-3">
                            <label class="col-md-12 col-form-label">MRP Price <span class="text-danger">*</span></label>
                        </div>
                        <div class="card-body p-3">
                            <input type="number" name="mrp" class="form-control" value="{{ old('mrp') }}" required step="0.01" min="0">
                        </div>
                    </div>

                    {{-- Sales Price --}}
                    <div class="card mt-3">
                        <div class="card-header p-3">
                            <label class="col-md-12 col-form-label">Sales Price <span class="text-danger">*</span></label>
                        </div>
                        <div class="card-body p-3">
                            <input type="number" name="sales_price" class="form-control" value="{{ old('sales_price') }}" required step="0.01" min="0">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="card mt-3">
                        <div class="card-header p-3">
                            <label class="col-md-12 col-form-label">Status</label>
                        </div>
                        <div class="card-body p-3">
                            <select class="form-select" name="status">
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}" {{ (string)old('status', 1) === (string)$key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Category --}}
                    <div class="card mt-3">
                        <div class="card-header p-3">
                            <label class="col-md-12 col-form-label">Category</label>
                        </div>
                        <div class="card-body p-3">
                            <select class="form-select" name="product_category" id="product_category">
                                <option value="">Select Category</option>
                                @foreach ($categories as $k => $v)
                                    <option value="{{ $k }}" @selected(old('product_category') == $k)>
                                        {{ $v }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Sub Category --}}
                    <div class="card mt-3">
                        <div class="card-header p-3">
                            <label class="col-md-12 col-form-label">Sub Category</label>
                        </div>
                        <div class="card-body p-3">
                            <select class="form-select"
                                    name="sub_product_category"
                                    id="sub_product_category"
                                    data-selected="{{ old('sub_product_category') }}">
                                <option value="">Select Sub Category</option>
                            </select>
                        </div>
                    </div>

                    {{-- Attribute Set --}}
                    <div class="card mt-3">
                        <div class="card-header p-3">
                            <label for="attribute_set_id" class="col-form-label">Attribute Set</label>
                        </div>
                        <div class="card-body p-3">
                            <select id="attribute_set_id" name="attribute_set_id" class="form-select select2">
                                <option value="">Select Attribute Set</option>
                                @foreach ($attributeSets as $id => $name)
                                    <option value="{{ $id }}" {{ (string)old('attribute_set_id') === (string)$id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            <small class="text-muted d-block mt-1">
                                After saving, you can fill attribute values & variants in the next step.
                            </small>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\ProductFormRequest', '#create-product') !!}

    {{-- If your template already loads select2 + jQuery globally, keep only below --}}
    <script type="module">
        $(function() {
            // Select2
            if ($.fn.select2) {
                $('.select2').select2({
                    width: '100%'
                });
            }

            const $categorySelect = $('#product_category');
            const $subCategorySelect = $('#sub_product_category');
            const subCategoryUrl = "{{ route('sysadmin.catalog.product.subcategories') }}";

            function clearSubCategories() {
                $subCategorySelect.html('<option value="">Select Sub Category</option>');
            }

            function loadSubCategories(parentId, preselectedId = null) {
                if (!parentId) {
                    clearSubCategories();
                    return;
                }

                $.ajax({
                    url: subCategoryUrl,
                    type: 'GET',
                    data: { parent_id: parentId },
                    dataType: 'json',
                    success: function(response) {
                        clearSubCategories();

                        if (!response || !response.success || $.isEmptyObject(response.data)) {
                            return;
                        }

                        $.each(response.data, function(id, name) {
                            const $opt = $('<option>', { value: id, text: name });
                            if (preselectedId && String(preselectedId) === String(id)) {
                                $opt.prop('selected', true);
                            }
                            $subCategorySelect.append($opt);
                        });
                    },
                    error: function(err) {
                        console.error('Error loading sub categories:', err);
                        clearSubCategories();
                    }
                });
            }

            // Load on change
            $categorySelect.on('change', function() {
                const parentId = $(this).val();
                clearSubCategories();
                loadSubCategories(parentId);
            });

            // Initial load (when validation fails / old input exists)
            const initialParentId = $categorySelect.val();
            const preselectedSubId = $subCategorySelect.data('selected') || null;

            if (initialParentId) {
                loadSubCategories(initialParentId, preselectedSubId);
            }
        });
    </script>
@endPushOnce
