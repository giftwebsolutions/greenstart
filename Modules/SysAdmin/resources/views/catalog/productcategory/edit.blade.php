@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/select2.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Edit Product Category</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Product Categories</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">
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
                <form id="edit-category" class="theme-form" method="POST" enctype="multipart/form-data"
                      action="{{ route('sysadmin.catalog.category.update', $category->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="card-body p-3">

                        {{-- Name --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Category Name</label>
                            <div class="col-md-12">
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $category->name) }}" required>
                                @error('name')
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
                                       value="{{ old('slug', $category->slug) }}">
                                @error('slug')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Parent Category --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Parent Category</label>
                            <div class="col-md-12">
                                <select class="form-select select2 @error('parent_id') is-invalid @enderror"
                                        name="parent_id">
                                    <option value="">None</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat['id'] }}"
                                            {{ (int) old('parent_id', $category->parent_id) === (int) $cat['id'] ? 'selected' : '' }}>
                                            {{ $cat['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="form-group mb-3">
                            <label class="col-md-12 col-form-label">Description</label>
                            <textarea name="description"
                                      class="form-control editor @error('description') is-invalid @enderror"
                                      rows="5">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Banner Image --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Banner Image</label>
                            <div class="col-md-12">
                                <input type="file" name="banner" id="banner"
                                       class="form-control @error('banner') is-invalid @enderror">
                                @error('banner')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror

                                @if ($category->banner)
                                    <div class="mt-3 text-center">
                                        <img id="bannerPreview" src="{{ asset($category->banner) }}" alt="Banner"
                                             class="img-fluid mb-2 rounded">
                                        <div id="remove-banner-block">
                                            <a href="javascript:void(0)" id="remove-banner" class="btn btn-danger btn-sm">
                                                Remove
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <img id="bannerPreview" src="" alt="" class="img-fluid d-none">
                                    <div id="remove-banner-block" class="d-none text-center">
                                        <a href="javascript:void(0)" id="remove-banner" class="btn btn-danger btn-sm">
                                            Remove
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Category Image --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Category Image</label>
                            <div class="col-md-12">
                                <input type="file" name="image" id="image"
                                       class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror

                                @if ($category->image)
                                    <div class="mt-3 text-center">
                                        <img id="imagePreview" src="{{ asset($category->image) }}" alt="Image"
                                             class="img-fluid mb-2 rounded">
                                        <div id="remove-image-block">
                                            <a href="javascript:void(0)" id="remove-image" class="btn btn-danger btn-sm">
                                                Remove
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <img id="imagePreview" src="" alt="" class="img-fluid d-none">
                                    <div id="remove-image-block" class="d-none text-center">
                                        <a href="javascript:void(0)" id="remove-image" class="btn btn-danger btn-sm">
                                            Remove
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Sort Order --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Sort Order</label>
                            <div class="col-md-12">
                                <input type="number"
                                       name="sort"
                                       class="form-control @error('sort') is-invalid @enderror"
                                       value="{{ old('sort', $category->sort ?? 0) }}">
                                @error('sort')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('sysadmin.catalog.category.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary mx-2">Update</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right column: status --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header p-3">
                    <label class="col-md-12 col-form-label">Status</label>
                </div>
                <div class="card-body p-3">
                    <select class="form-select @error('status') is-invalid @enderror" name="status">
                        @foreach ($statuses as $key => $value)
                            <option value="{{ $key }}"
                                {{ (int) old('status', $category->status) === (int) $key ? 'selected' : '' }}>
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
    </div>
</div>
@endsection

@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\ProductCategoryFormRequest', '#edit-category') !!}

    <script type="module">
        // Handle banner preview
        const bannerInput = document.getElementById('banner');
        const bannerPreview = document.getElementById('bannerPreview');
        const bannerRemove = document.getElementById('remove-banner');
        const bannerBlock = document.getElementById('remove-banner-block');

        if (bannerInput) {
            bannerInput.addEventListener('change', e => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        bannerPreview.src = e.target.result;
                        bannerPreview.classList.remove('d-none');
                        bannerBlock.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (bannerRemove) {
            bannerRemove.addEventListener('click', () => {
                bannerInput.value = '';
                bannerPreview.src = '';
                bannerPreview.classList.add('d-none');
                bannerBlock.classList.add('d-none');
            });
        }

        // Handle image preview
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const imageRemove = document.getElementById('remove-image');
        const imageBlock = document.getElementById('remove-image-block');

        if (imageInput) {
            imageInput.addEventListener('change', e => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                        imageBlock.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (imageRemove) {
            imageRemove.addEventListener('click', () => {
                imageInput.value = '';
                imagePreview.src = '';
                imagePreview.classList.add('d-none');
                imageBlock.classList.add('d-none');
            });
        }
    </script>
@endPushOnce

@section('script')
    <script type="module" src="{{ asset('admin/js/select2/select2.full.min.js') }}"></script>
@endsection
