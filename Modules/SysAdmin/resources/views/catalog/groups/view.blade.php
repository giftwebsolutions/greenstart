@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $group->name }}</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Attributes</li>
    <li class="breadcrumb-item active">Group View</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-12 text-start my-3">
        <div class="d-flex" role="group">
            <a href="{{ url()->previous() }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-title="Back">
                <i class="bi bi-arrow-left"></i>
            </a>
            <a href="{{ route('sysadmin.catalog.attribute.group.edit', $group->id) }}" class="btn btn-primary mx-2" data-bs-toggle="tooltip" data-bs-title="Edit">
                <i class="bi bi-pencil-fill"></i>
            </a>
            <a href="{{ route('sysadmin.catalog.attribute.group.index') }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-title="List">
                <i class="bi bi-list"></i>
            </a>
        </div>
    </div>

    <div class="card p-1">
        <div class="card-header p-3">
            <div class="row">
                <div class="col-12 border-bottom">
                    <h4 class="title mb-2">Group Details</h4>
                </div>
                <div class="col-md-8 mt-2">
                    <h1 class="fs-4 mb-1">{{ $group->name }}</h1>
                    <p class="mb-1"><strong>Slug:</strong> {{ $group->slug ?? '—' }}</p>
                    <p class="mb-0">
                        <strong>Attributes count:</strong>
                        {{ $group->attributes_count ?? ($group->relationLoaded('attributes') ? $group->attributes->count() : $group->attributes()->count()) }}
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-2">
                    @php
                        $label = $statuses[$group->status] ?? $group->status;
                        $cls   = match((int)$group->status){
                            1 => 'bg-success',
                            2 => 'bg-warning text-dark',
                            0 => 'bg-danger',
                            default => 'bg-secondary'
                        };
                    @endphp
                    <p class="mb-1">
                        <strong>Status:</strong>
                        <span class="badge {{ $cls }}">{{ $label }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="card-body p-3">
            <div class="row">
                {{-- Core --}}
                <div class="col-md-6">
                    <div class="border rounded p-3 mb-3">
                        <h6 class="border-bottom pb-2 mb-3">Core</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">ID</span><span>{{ $group->id }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Name</span><span>{{ $group->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Slug</span><span>{{ $group->slug ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <div class="border rounded p-3 mb-3">
                        <h6 class="border-bottom pb-2 mb-3">Status</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status</span><span>{{ $label }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Attributes mapped to this group --}}
            <div class="border rounded p-3">
                <h6 class="border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                    <span>Mapped Attributes</span>
                    <a href="{{ route('sysadmin.catalog.attribute.group.edit', $group->id) }}" class="btn btn-sm btn-outline-primary">
                        Manage
                    </a>
                </h6>

                @php
                    // Prefer eager-loaded relation to avoid extra query
                    $attributes = $group->relationLoaded('attributes') ? $group->attributes : $group->attributes()->get();
                @endphp

                @if($attributes->isEmpty())
                    <p class="text-muted mb-0">No attributes are linked to this group yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">ID</th>
                                    <th>Attribute</th>
                                    <th style="width: 30%;">Value (pivot)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attributes as $attr)
                                    <tr>
                                        <td>{{ $attr->id }}</td>
                                        <td>{{ $attr->name }}</td>
                                        <td>{{ $attr->pivot->value ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
