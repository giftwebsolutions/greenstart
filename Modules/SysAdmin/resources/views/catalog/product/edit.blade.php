@extends('sysadmin::layouts.master')

@section('breadcrumb-title')<h3>Edit Product</h3>@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.catalog.product.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="container-fluid">
        <livewire:sysadmin.catalog.products.form-wizard :id="$productId" />
    </div>
@endsection
