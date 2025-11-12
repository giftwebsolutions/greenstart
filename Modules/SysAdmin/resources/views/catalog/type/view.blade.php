@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $type->type_name }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Catalog</li>
    <li class="breadcrumb-item">Attributes</li>
    <li class="breadcrumb-item active">Type View</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-12 text-start my-3">
        <div class="d-flex" role="group">
            <a href="{{ url()->previous() }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-title="Back">
                <i class="bi bi-arrow-left"></i>
            </a>
            <a href="{{ route('sysadmin.catalog.attribute.type.edit', $type->attribute_type_id) }}" class="btn btn-primary mx-2" data-bs-toggle="tooltip" data-bs-title="Edit">
                <i class="bi bi-pencil-fill"></i>
            </a>
            <a href="{{ route('sysadmin.catalog.attribute.type.index') }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-title="List">
                <i class="bi bi-list"></i>
            </a>
        </div>
    </div>

    <div class="card p-1">
        <div class="card-header p-3">
            <div class="row">
                <div class="col-12 border-bottom">
                    <h4 class="title mb-2">Type Details</h4>
                </div>

                <div class="col-md-8 mt-2">
                    <h1 class="fs-4 mb-1">{{ $type->type_name }}</h1>
                    <p class="mb-1"><strong>Identifier:</strong> {{ $type->identifier ?? '—' }}</p>
                </div>

                <div class="col-md-4 text-md-end mt-2">
                    @php
                        $statuses = $statuses ?? [0=>'Delete',1=>'Published',2=>'Draft'];
                        $label    = $statuses[$type->status] ?? $type->status;
                        $cls      = match((int)$type->status){1=>'bg-success',2=>'bg-warning text-dark',0=>'bg-danger',default=>'bg-secondary'};
                    @endphp
                    <p class="mb-0"><strong>Status:</strong> <span class="badge {{ $cls }}">{{ $label }}</span></p>
                </div>
            </div>
        </div>

        <div class="card-body p-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="border rounded p-3 mb-3">
                        <h6 class="border-bottom pb-2 mb-3">Core</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">ID</span><span>{{ $type->attribute_type_id }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Type Name</span><span>{{ $type->type_name }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Identifier</span><span>{{ $type->identifier ?? '—' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3 mb-3">
                        <h6 class="border-bottom pb-2 mb-3">Status</h6>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Status</span><span>{{ $label }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
