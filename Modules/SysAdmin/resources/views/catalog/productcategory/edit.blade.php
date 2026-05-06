@php
    // dd($category);
@endphp

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
    <form id="edit-category" class="theme-form" method="POST" enctype="multipart/form-data"
        action="{{ route('sysadmin.catalog.productcategory.update', $category->id) }}">

        @csrf
        @method('PATCH')

        <div class="row">

            {{-- Errors --}}
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-secondary alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>

            {{-- LEFT --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-3">

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="col-form-label">Category Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $category->name) }}" required>
                        </div>

                        {{-- Slug --}}
                        <div class="mb-3">
                            <label class="col-form-label">Slug</label>
                            <input type="text" name="slug" class="form-control"
                                value="{{ old('slug', $category->slug) }}">
                        </div>

                        {{-- Parent --}}
                        <div class="mb-3">
                            <label class="col-form-label">Parent Category</label>
                            <select name="parent_id" class="form-select select2">
                                <option value="">None</option>
                                @foreach ($parents as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (int) old('parent_id', $category->parent_id) === (int) $k ? 'selected' : '' }}>
                                        {{ $v }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="col-form-label">Description</label>

                            <div class="editor"
                                data-name="description">{!! old('description', $category->description ?? '') !!}</div>

                            <input type="hidden" name="description"
                                value="{{ old('description', $category->description ?? '') }}">
                        </div>

                        {{-- BANNER IMAGE --}}
                        <div class="mb-3">
                            <label class="col-form-label">Banner Image</label>
                            <input type="file" name="banner" id="banner-image" class="form-control">

                            <input type="hidden" name="remove_banner" id="remove_banner" value="0">

                            <div class="mt-3 text-center">
                                @if ($category->banner)
                                    <img id="bannerPreview"
                                        src="{{ asset(Modules\SysAdmin\Helpers\ImageUploader::getFilePath(
                                            $category->banner,
                                            $category->created_at,
                                            'thumbnail'
                                        )) }}"
                                        class="img-fluid mb-2 rounded">
                                @else
                                    <img id="bannerPreview" class="img-fluid mb-2 rounded d-none" src="">
                                @endif
                                <div id="remove-banner-block"
                                    class="{{ $category->banner ? '' : 'd-none' }}">
                                    <button type="button" id="remove-banner"
                                        class="btn btn-danger btn-sm">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- CATEGORY IMAGE --}}
                        <div class="mb-3">
                            <label class="col-form-label">Category Image</label>
                            <input type="file" name="image" id="image-input" class="form-control">

                            <input type="hidden" name="remove_image" id="remove_image" value="0">

                            <div class="mt-3 text-center">
                                @if ($category->image)
                                    <img id="imagePreview"
                                        src="{{ Modules\SysAdmin\Helpers\ImageUploader::getFilePath(
                                            $category->image,
                                            $category->created_at,
                                            'thumbnail'
                                        ) }}"
                                        class="img-fluid mb-2 rounded">
                                @else
                                    <img id="imagePreview" class="img-fluid mb-2 rounded d-none">
                                @endif

                                <div id="remove-image-block"
                                    class="{{ $category->image ? '' : 'd-none' }}">
                                    <button type="button" id="remove-image"
                                        class="btn btn-danger btn-sm">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Sort --}}
                        <div class="mb-3">
                            <label class="col-form-label">Sort Order</label>
                            <input type="number" name="sort" class="form-control"
                                value="{{ old('sort', $category->sort ?? 0) }}">
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('sysadmin.catalog.productcategory.index') }}"
                            class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary mx-2">
                            Update
                        </button>
                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header p-3">
                        <label class="col-form-label">Status</label>
                    </div>
                    <div class="card-body p-3">
                        <select name="status" class="form-select">
                            @foreach ($statuses as $key => $value)
                                <option value="{{ $key }}"
                                    {{ (int) old('status', $category->status) === (int) $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@pushOnce('scripts')
 <script type="module">
$(function () {

    // ---------- BANNER ----------
    $('#banner-image').on('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            $('#bannerPreview').attr('src', e.target.result).removeClass('d-none');
            $('#remove-banner-block').removeClass('d-none');
            $('#remove_banner').val(0);
        };
        reader.readAsDataURL(file);
    });

    $('#remove-banner').on('click', function () {
        $('#banner-image').val('');
        $('#bannerPreview').attr('src', '').addClass('d-none');
        $('#remove-banner-block').addClass('d-none');
        $('#remove_banner').val(1);
    });

    // ---------- CATEGORY IMAGE ----------
    $('#image-input').on('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            $('#imagePreview').attr('src', e.target.result).removeClass('d-none');
            $('#remove-image-block').removeClass('d-none');
            $('#remove_image').val(0);
        };
        reader.readAsDataURL(file);
    });

    $('#remove-image').on('click', function () {
        $('#image-input').val('');
        $('#imagePreview').attr('src', '').addClass('d-none');
        $('#remove-image-block').addClass('d-none');
        $('#remove_image').val(1);
    });

});
</script>
@endPushOnce
