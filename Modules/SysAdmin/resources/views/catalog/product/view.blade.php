@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>View Product</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Products</li>
    <li class="breadcrumb-item active">{{ $product->title }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card p-3">
                <h4>{{ $product->title }}</h4>
                <p><strong>SKU:</strong> {{ $product->sku }}</p>
                <p><strong>Status:</strong> {{ $status }}</p>
                <p><strong>Category:</strong> {{ $category->name ?? '-' }}</p>
                <p><strong>Sub Category:</strong> {{ $subCategory->name ?? '-' }}</p>
                <hr>
                <p><strong>Short Description</strong></p>
                <p>{{ $product->short_description }}</p>
                <hr>
                <p><strong>Description</strong></p>
                <div>{!! nl2br(e($product->description)) !!}</div>
            </div>
        </div>

        <div class="col-md-4">
            @if($product->thumb)
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Thumbnail</h6>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset($product->thumb) }}" alt="" class="img-fluid">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
