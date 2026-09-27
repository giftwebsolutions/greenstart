@extends('sysadmin::layouts.master')

@section('breadcrumb-title')<h3>Create Product</h3>@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.catalog.product.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="container-fluid">
        <livewire:sysadmin.catalog.products.form-wizard />
    </div>
@endsection
