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

        <form id="edit-product" class="theme-form" method="POST" enctype="multipart/form-data"
            action="{{ route('sysadmin.catalog.product.update', $product->id) }}">
            @csrf
            @method('PUT')
            <div class="row">

                {{-- Error block --}}
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                {{-- Left column: main form --}}
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-body p-3">

                            {{-- Title --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Product Title</label>
                                <div class="col-md-12">
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $product->title) }}" required>
                                    @error('title')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Slug --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Slug</label>
                                <div class="col-md-12">
                                    <input type="text" name="slug"
                                        class="form-control @error('slug') is-invalid @enderror"
                                        value="{{ old('slug', $product->slug) }}">
                                    @error('slug')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Keywords --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Keywords</label>
                                <div class="col-md-12">
                                    <input type="text" name="keywords"
                                        class="form-control @error('keywords') is-invalid @enderror"
                                        value="{{ old('keywords', $product->keywords) }}">
                                    @error('keywords')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Short Description --}}
                            <div class="form-group mb-3">
                                <label class="col-md-12 col-form-label">Short Description</label>
                                <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                                @error('short_description')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="form-group mb-3">
                                <label class="col-md-12 col-form-label">Description</label>
                                <textarea name="description" class="form-control editor @error('description') is-invalid @enderror" rows="8">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- SKU --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">SKU</label>
                                <div class="col-md-12">
                                    <input type="text" name="sku"
                                        class="form-control @error('sku') is-invalid @enderror"
                                        value="{{ old('sku', $product->sku) }}">
                                    @error('sku')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Product Type --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Product Type</label>
                                <div class="col-md-12">
                                    <select class="form-select @error('type') is-invalid @enderror" name="type">
                                        <option value="1" {{ old('type', $product->type) == 1 ? 'selected' : '' }}>
                                            Simple</option>
                                        <option value="2" {{ old('type', $product->type) == 2 ? 'selected' : '' }}>
                                            Variable</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Video URL --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Video URL</label>
                                <div class="col-md-12">
                                    <input type="text" name="video"
                                        class="form-control @error('video') is-invalid @enderror"
                                        value="{{ old('video', $product->video) }}">
                                    @error('video')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Catalog URL --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Catalog URL</label>
                                <div class="col-md-12">
                                    <input type="text" name="catalog"
                                        class="form-control @error('catalog') is-invalid @enderror"
                                        value="{{ old('catalog', $product->catalog) }}">
                                    @error('catalog')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Sort Order & Order --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="col-form-label">Sort Order</label>
                                    <input type="number" name="sort_order"
                                        class="form-control @error('sort_order') is-invalid @enderror"
                                        value="{{ old('sort_order', $product->sort_order) }}">
                                    @error('sort_order')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label">Display Order</label>
                                    <input type="number" name="order"
                                        class="form-control @error('order') is-invalid @enderror"
                                        value="{{ old('order', $product->order) }}">
                                    @error('order')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Hits --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Hits</label>
                                <div class="col-md-12">
                                    <input type="number" name="hits"
                                        class="form-control @error('hits') is-invalid @enderror"
                                        value="{{ old('hits', $product->hits) }}">
                                    @error('hits')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Feature & Slider checkboxes --}}
                            <div class="row mb-3">
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                        value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Featured Product</label>
                                </div>

                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" type="checkbox" id="slider" name="slider"
                                        value="1" {{ old('slider', $product->slider) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="slider">Show in Slider</label>
                                </div>
                            </div>

                            {{-- Thumbnail file --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Thumbnail Image</label>
                                <div class="col-md-12">
                                    <input type="file" name="thumb" id="thumb"
                                        class="form-control @error('thumb') is-invalid @enderror">
                                    @error('thumb')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror

                                    <div class="mt-3">
                                        @php
                                            $thumb = old('thumb_path', $product->thumb);
                                        @endphp
                                        @if ($thumb)
                                            <img id="thumbPreview" src="{{ asset($thumb) }}" alt="Thumbnail"
                                                class="img-fluid mb-2">
                                        @else
                                            <img id="thumbPreview" src="" alt=""
                                                class="img-fluid d-none">
                                        @endif
                                        <div id="remove-thumb-block" class="{{ $thumb ? '' : 'd-none' }} text-center">
                                            <a href="javascript:void(0)" id="remove-thumb" class="btn btn-danger btn-sm">
                                                Remove
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> {{-- card-body --}}

                        <div class="card-footer text-end">
                            <a href="{{ route('sysadmin.catalog.product.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Update</button>
                        </div>


                    </div>
                </div>

                {{-- Right column: status & categories --}}
                <div class="col-md-4">

                    {{-- Status --}}
                    <div class="card">
                        <div class="card-header p-3">
                            <label class="col-md-12 col-form-label">Status</label>
                        </div>
                        <div class="card-body p-3">
                            <select class="form-select @error('status') is-invalid @enderror" name="status">
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ (int) old('status', $product->status) === (int) $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Category --}}
                    <div class="card mt-3">
                        <div class="card-header p-3">
                            <label class="col-md-12 col-form-label">Category</label>
                        </div>
                        <div class="card-body p-3">
                            <select class="form-select @error('product_category') is-invalid @enderror"
                                name="product_category" id="product_category">
                                <option>Select Category</option>
                                @foreach ($categories as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (int) old('product_category', $product->product_category) === (int) $k ? 'selected' : '' }}>
                                        {{ $v }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_category')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Sub Category --}}
                    <div class="card mt-3">
                        <div class="card-header p-3">
                            <label class="col-md-12 col-form-label">Sub Category</label>
                        </div>
                        <div class="card-body p-3">
                            <select class="form-select @error('sub_product_category') is-invalid @enderror"
                                name="sub_product_category" id="sub_product_category">
                                <option>Select Sub Category</option>
                                @foreach ($subCategories as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (int) old('sub_product_category', $product->sub_product_category) === (int) $k ? 'selected' : '' }}>
                                        {{ $v }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sub_product_category')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

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
