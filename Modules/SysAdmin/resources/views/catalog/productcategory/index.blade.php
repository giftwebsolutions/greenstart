@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Products</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Catalog</li>
    <li class="breadcrumb-item active">ProductCategory</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3 text-end">
                <a href="{{ route('sysadmin.catalog.productcategory.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Create ProductCategory
                </a>
            </div>

            <div class="col-12">
                <div class="card p-2">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-bordered table-striped']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
