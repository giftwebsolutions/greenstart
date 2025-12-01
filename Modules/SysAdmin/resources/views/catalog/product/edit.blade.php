@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    use Carbon\Carbon;

    // Convert UNIX created_at → normal datetime string
    $createdAt = isset($product->created_at) && $product->created_at
        ? Carbon::createFromTimestamp($product->created_at)->toDateTimeString()
        : null;

    // Build thumbnail path via helper if thumb exists
    $thumbPath = null;

    if ($product->thumb && $createdAt) {
        $thumbPath = ImageUploader::getFilePath($product->thumb, $createdAt, 'thumbnail');
    }

    // Allow old() to override if there was a validation error
    $thumbPath = old('thumb_path', $thumbPath);
@endphp

@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/select2.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Edit Product</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Products</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="container-fluid">

    <form id="edit-product"
              class="theme-form"
              method="POST"
              enctype="multipart/form-data"
              action="{{ route('sysadmin.catalog.product.update', $product->id) }}">

            @csrf
            @method('PATCH')

            <div class="row">
                {{-- Error Handling --}}
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
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
                                <label class="col-md-12 col-form-label">Product Title</label>
                                <div class="col-md-12">
                                    <input type="text"
                                           name="title"
                                           class="form-control"
                                           value="{{ old('title', $product->title) }}"
                                           required>
                                </div>
                            </div>

                            {{-- Keywords --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Keywords</label>
                                <div class="col-md-12">
                                    <input type="text"
                                           name="keywords"
                                           class="form-control"
                                           value="{{ old('keywords', $product->keywords) }}">
                                </div>
                            </div>

                            {{-- Short Description --}}
                            <div class="form-group mb-3">
                                <label class="col-md-12 col-form-label">Short Description</label>
                                <textarea name="short_description"
                                          class="form-control"
                                          rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                            </div>

                            {{-- Description --}}
                            <div class="form-group mb-3">
                                <label class="col-md-12 col-form-label">Description</label>
                                <textarea name="description"
                                          class="form-control editor"
                                          rows="8">{{ old('description', $product->description) }}</textarea>
                            </div>

                            {{-- SKU --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">SKU</label>
                                <div class="col-md-12">
                                    <input type="text"
                                           name="sku"
                                           class="form-control"
                                           value="{{ old('sku', $product->sku) }}">
                                </div>
                            </div>

                            {{-- Product Type --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Product Type</label>
                                <div class="col-md-12">
                                    <select class="form-select" name="type">
                                        <option value="1"
                                            {{ old('type', $product->type) == 1 ? 'selected' : '' }}>
                                            Simple
                                        </option>
                                        <option value="2"
                                            {{ old('type', $product->type) == 2 ? 'selected' : '' }}>
                                            Variable
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{-- Video --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Video URL</label>
                                <div class="col-md-12">
                                    <input type="text"
                                           name="video"
                                           class="form-control"
                                           value="{{ old('video', $product->video) }}">
                                </div>
                            </div>

                            {{-- Catalog --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Catalog URL</label>
                                <div class="col-md-12">
                                    <input type="text"
                                           name="catalog"
                                           class="form-control"
                                           value="{{ old('catalog', $product->catalog) }}">
                                </div>
                            </div>

                            {{-- Thumb Image --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Thumbnail Image</label>
                                <div class="col-md-12">
                                    <input type="file" name="thumb" class="form-control">
                                    @if ($product->thumb_path ?? false)
                                        <div class="mt-2">
                                            <img src="{{ $product->thumb_path }}"
                                                 alt="Thumbnail"
                                                 style="max-height:80px;">
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('sysadmin.catalog.product.index') }}"
                               class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Update</button>
                        </div>
                    </div>
                </div>

                {{-- RIGHT PANEL --}}
                <div class="col-md-4">

                    {{-- Status --}}
                    <div class="card">
                        <div class="card-header p-3">
                            <label class="col-md-12 col-form-label">Status</label>
                        </div>
                        <div class="card-body p-3">
                            <select class="form-select" name="status">
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ (int) old('status', $product->status) === (int) $key ? 'selected' : '' }}>
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
                            <select class="form-select" name="product_category">
                                <option value="">Select Category</option>
                                @foreach ($categories as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (int) old('product_category', $product->product_category) === (int) $k ? 'selected' : '' }}>
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
                            <select class="form-select" name="sub_product_category">
                                <option value="">Select Sub Category</option>
                                @foreach ($subCategories as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (int) old('sub_product_category', $product->sub_product_category) === (int) $k ? 'selected' : '' }}>
                                        {{ $v }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Attribute Set --}}
                    <div class="card mt-3">
                        <div class="card-header p-3">
                            <label for="attribute_set_id" class="col-form-label">Attribute Set</label>
                        </div>
                        <div class="card-body p-3">
                            <select id="attribute_set_id"
                                    name="attribute_set_id"
                                    class="form-select select2">
                                <option value="">Select Attribute Set</option>
                                @foreach ($attributeSets as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ (int) old('attribute_set_id', $product->attribute_set_id) === (int) $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block mt-1">
                                After saving, manage attribute values & variants in the next step.
                            </small>
                        </div>
                    </div>

                    {{-- Manage Attributes & Variants --}}
                    @if ((int) $product->type === 2 || $product->attribute_set_id)
                        <div class="card mt-3">
                            <div class="card-body p-3">
                                <p class="mb-2">
                                    Go to the Attributes page to fill attribute values
                                    @if((int)$product->type === 2)
                                        and manage variants.
                                    @endif
                                </p>
                                <a href="{{ route('sysadmin.catalog.product.attributes', $product->id) }}"
                                   class="btn btn-outline-primary w-100">
                                    Manage Attributes @if((int)$product->type === 2)& Variants @endif
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection

@pushOnce('scripts')
    {{-- JsValidator --}}
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\ProductFormRequest', '#edit-product') !!}

    <script type="module">
        // Cancel button (if you add one separately)
        // $('a#cancel-button').click(function() {
        //     window.location.href = "{{ route('sysadmin.catalog.product.index') }}";
        // });

        // Thumbnail preview & remove
        let thumbFile;
        const thumbInput = document.getElementById('thumb');
        const thumbImg = document.getElementById('thumbPreview');
        const removeBlock = document.getElementById('remove-thumb-block');
        const removeBtn = document.getElementById('remove-thumb');

        if (thumbInput) {
            thumbInput.addEventListener('change', function(e) {
                thumbFile = this.files[0];
                if (thumbFile) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        thumbImg.src = event.target.result;
                        thumbImg.classList.remove('d-none');
                        removeBlock.classList.remove('d-none');
                    };
                    reader.readAsDataURL(thumbFile);
                }
            });
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                thumbFile = null;
                if (thumbInput) {
                    thumbInput.value = '';
                }
                thumbImg.src = '';
                thumbImg.classList.add('d-none');
                removeBlock.classList.add('d-none');
            });
        }
    </script>
@endPushOnce

@section('script')
    <script type="module" src="{{ asset('admin/js/select2/select2.full.min.js') }}"></script>
@endsection
