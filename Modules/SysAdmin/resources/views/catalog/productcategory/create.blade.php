@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/select2.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Create Product Category</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Product Categories</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="container-fluid">
        <form id="create-category" class="theme-form" method="POST" enctype="multipart/form-data"
            action="{{ route('sysadmin.catalog.productcategory.store') }}">
            @csrf
            <div class="row">
                {{-- Error Handling --}}
                <div class="col-12">
                    @if ($errors->any())
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


                        <div class="card-body p-3">

                            {{-- Name --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Category Name</label>
                                <div class="col-md-12">
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                        required>
                                </div>
                            </div>

                            {{-- Parent Category --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Parent Category</label>
                                <div class="col-md-12">
                                    <select class="form-select select2" name="parent_id">
                                        <option value="">None</option>
                                        @foreach ($parents as $k => $v)
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="form-group mb-3">
                                <label class="col-md-12 col-form-label">Description</label>
                                <textarea name="description" class="form-control editor" rows="5">{{ old('description') }}</textarea>
                            </div>

                            {{-- Banner Image --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Banner Image</label>
                                <div class="col-md-12">
                                    <input type="file" name="banner" class="form-control">
                                </div>
                            </div>

                            {{-- Category Image --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Category Image</label>
                                <div class="col-md-12">
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>

                            {{-- Sort Order --}}
                            <div class="row mb-3">
                                <label class="col-md-12 col-form-label">Sort Order</label>
                                <div class="col-md-12">
                                    <input type="number" name="sort" class="form-control" value="{{ old('sort', 0) }}">
                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('sysadmin.catalog.productcategory.index') }}"
                                class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Submit</button>
                        </div>


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
                                    <option value="{{ $key }}" {{ $key == 1 ? 'selected' : '' }}>
                                        {{ $value }}</option>
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
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\ProductCategoryFormRequest', '#create-category') !!}
@endPushOnce
