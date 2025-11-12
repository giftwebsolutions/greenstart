@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ $attribute->name }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Attributes</li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- Action buttons --}}
            <div class="col-12 text-start my-3">
                <div class="d-flex" role="group">
                    <a href="{{ url()->previous() }}" data-bs-toggle="tooltip" data-bs-placement="top"
                       data-bs-title="Back" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <a href="{{ route('sysadmin.catalog.attribute.edit', $attribute->id) }}" data-bs-toggle="tooltip"
                       data-bs-placement="top" data-bs-title="Edit" class="btn btn-primary mx-2">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="{{ route('sysadmin.catalog.attribute.index') }}" data-bs-toggle="tooltip"
                       data-bs-placement="top" data-bs-title="List" class="btn btn-primary">
                        <i class="bi bi-list"></i>
                    </a>
                </div>
            </div>

            <div class="col-12">
                <div class="card p-1">
                    {{-- Header / meta --}}
                    <div class="card-header p-3">
                        <div class="row">
                            <div class="col-12 border-bottom">
                                <h4 class="title mb-2">Attribute Details</h4>
                            </div>

                            <div class="col-md-8 mt-2">
                                <h1 class="fs-4 mb-1">{{ $attribute->name }}</h1>

                                <div class="mt-2">
                                    <p class="mb-1">
                                        <strong>Group:</strong>
                                        {{ optional($attribute->attribute_group)->name ?? '—' }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Type:</strong>
                                        {{ optional($attribute->attribute_type)->name ?? '—' }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Sort Order:</strong>
                                        {{ $attribute->sort_order ?? 0 }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Comparable:</strong>
                                        @if($attribute->comparable)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </p>
                                    <p class="mb-1">
                                        <strong>Requirement:</strong>
                                        <span class="badge bg-info text-dark">{{ $attribute->require }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-4 text-md-end mt-2">
                                <p class="mb-1">
                                    <strong>Status:</strong>
                                    @php
                                        $statusLabel = $statuses[$attribute->status] ?? $attribute->status;
                                        $statusClass = match ((int)$attribute->status) {
                                            1 => 'bg-success',
                                            2 => 'bg-warning text-dark',
                                            0 => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                </p>
                                @if(!empty($attribute->updated_at))
                                    <p class="mb-1">
                                        <strong>Last Updated:</strong>
                                        {{ \Carbon\Carbon::parse($attribute->updated_at)->format('d-m-Y H:i:s') }}
                                    </p>
                                @endif
                                @if(!empty($attribute->created_at))
                                    <p class="mb-0">
                                        <strong>Created:</strong>
                                        {{ \Carbon\Carbon::parse($attribute->created_at)->format('d-m-Y H:i:s') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="border rounded p-3 mb-3">
                                    <h6 class="border-bottom pb-2 mb-3">Core</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">ID</span>
                                        <span>{{ $attribute->id }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Name</span>
                                        <span>{{ $attribute->name }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Group</span>
                                        <span>{{ optional($attribute->attribute_group)->name ?? '—' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Type</span>
                                        <span>{{ optional($attribute->attribute_type)->name ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="border rounded p-3 mb-3">
                                    <h6 class="border-bottom pb-2 mb-3">Behavior</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Comparable</span>
                                        <span>{{ $attribute->comparable ? 'Yes' : 'No' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Require</span>
                                        <span>{{ $attribute->require }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Sort Order</span>
                                        <span>{{ $attribute->sort_order ?? 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Status</span>
                                        <span>{{ $statusLabel }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- If you have any extra JSON/meta in future, render here --}}
                        {{-- <pre class="mt-3">{{ json_encode($attribute->toArray(), JSON_PRETTY_PRINT) }}</pre> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@pushOnce('scripts')
@endPushOnce
