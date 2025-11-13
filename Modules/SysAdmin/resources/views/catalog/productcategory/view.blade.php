@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>View Product Category</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Product Categories</li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Main Info --}}
        <div class="col-md-8">
            <div class="card p-3">
                <h4>{{ $category->name }}</h4>
                <p><strong>Slug:</strong> {{ $category->slug ?? '-' }}</p>
                <p><strong>Parent Category:</strong> {{ $parentCategory->name ?? '—' }}</p>
                <p><strong>Status:</strong> {{ $status ?? '-' }}</p>
                <p><strong>Sort Order:</strong> {{ $category->sort ?? 0 }}</p>

                <hr>

                <p><strong>Description</strong></p>
                <div>{!! nl2br(e($category->description)) !!}</div>
            </div>
        </div>

        {{-- Right Column for Images --}}
        <div class="col-md-4">
            {{-- Banner --}}
            @if($category->banner)
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Banner</h6>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset($category->banner) }}" alt="Banner" class="img-fluid rounded">
                    </div>
                </div>
            @endif

            {{-- Category Image --}}
            @if($category->image)
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Category Image</h6>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset($category->image) }}" alt="Image" class="img-fluid rounded">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
