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
    <div class="row">
        {{-- Error Handling --}}
        <div class="col-12">
            @if($errors->any())
                <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="card">
                <form id="create-product" class="theme-form" method="POST" enctype="multipart/form-data"
                      action="{{ route('sysadmin.catalog.product.store') }}">
                    @csrf

                    <div class="card-body p-3">

                        {{-- Title --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Product Title</label>
                            <div class="col-md-12">
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                            </div>
                        </div>

                        {{-- Keywords --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Keywords</label>
                            <div class="col-md-12">
                                <input type="text" name="keywords" class="form-control" value="{{ old('keywords') }}">
                            </div>
                        </div>

                        {{-- Short Description --}}
                        <div class="form-group mb-3">
                            <label class="col-md-12 col-form-label">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="3">{{ old('short_description') }}</textarea>
                        </div>

                        {{-- Description --}}
                        <div class="form-group mb-3">
                            <label class="col-md-12 col-form-label">Description</label>
                            <textarea name="description" class="form-control editor" rows="8">{{ old('description') }}</textarea>
                        </div>

                        {{-- SKU --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">SKU</label>
                            <div class="col-md-12">
                                <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                            </div>
                        </div>

                        {{-- Product Type --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Product Type</label>
                            <div class="col-md-12">
                                <select class="form-select" name="type">
                                    <option value="1">Simple</option>
                                    <option value="2">Variable</option>
                                </select>
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
                                <input type="file" name="thumb" class="form-control">
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('sysadmin.catalog.product.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary mx-2">Submit</button>
                    </div>

                </form>
            </div>
        </div>

        {{-- Right Panel --}}
        <div class="col-md-4">

            {{-- Status --}}
            <div class="card">
                <div class="card-header p-3">
                    <label class="col-md-12 col-form-label">Status</label>
                </div>
                <div class="card-body p-3">
                    <select class="form-select" name="status">
                        @foreach ($statuses as $key => $value)
                            <option value="{{ $key }}" {{ $key == 1 ? 'selected' : '' }}>{{ $value }}</option>
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
                        <option>Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
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
                        <option>Select Sub Category</option>
                        @foreach($subCategories as $cat)
                            <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\ProductFormRequest', '#create-product') !!}
@endPushOnce
