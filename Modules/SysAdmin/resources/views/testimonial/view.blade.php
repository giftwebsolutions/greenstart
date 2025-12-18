@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $testimonial->name }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Testimonials</li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Action buttons --}}
    <div class="col-12 text-start my-3">
        <div class="d-flex" role="group">
            <a href="{{ url()->previous() }}" class="btn btn-primary" data-bs-toggle="tooltip" title="Back">
                <i class="bi bi-arrow-left"></i>
            </a>
            <a href="{{ route('sysadmin.testimonial.edit', $testimonial->id) }}" class="btn btn-primary mx-2" data-bs-toggle="tooltip" title="Edit">
                <i class="bi bi-pencil-fill"></i>
            </a>
            <a href="{{ route('sysadmin.testimonial.index') }}" class="btn btn-primary" data-bs-toggle="tooltip" title="List">
                <i class="bi bi-list"></i>
            </a>
        </div>
    </div>

    {{-- Card --}}
    <div class="card p-1">

        {{-- Header --}}
        <div class="card-header p-3">
            <div class="row">
                <div class="col-12 border-bottom">
                    <h4 class="title mb-2">Testimonial Details</h4>
                </div>
                <div class="col-md-8 mt-2">
                    <h1 class="fs-4 mb-1">{{ $testimonial->name }}</h1>
                    {{-- <p class="mb-1"><strong>Content:</strong></p>
                    <p>{{ $testimonial->content }}</p> --}}
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body p-3">
            <div class="row">

                {{-- Core info --}}
                <div class="col-md-6">
                    <div class="border rounded p-3 mb-3">
                        <h6 class="border-bottom pb-2 mb-3">Core</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">ID</span><span>{{ $testimonial->id }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Name</span><span>{{ $testimonial->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Name</span><span>{{ $testimonial->content }}</span>
                        </div>
                        @if($testimonial->image)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Image</span>
                            <span>
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="img-fluid" style="max-height: 100px;">
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Timestamps --}}
                <div class="col-md-6">
                    <div class="border rounded p-3 mb-3">
                        <h6 class="border-bottom pb-2 mb-3">Timestamps</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Created At</span><span>{{ $testimonial->created_at?->format('d-m-Y H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Updated At</span><span>{{ $testimonial->updated_at?->format('d-m-Y H:i') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
