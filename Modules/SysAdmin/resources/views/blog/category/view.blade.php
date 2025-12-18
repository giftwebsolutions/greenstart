@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $page['name'] }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Pages</li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Action buttons --}}
    <div class="col-12 text-start my-3">
        <div class="d-flex" role="group">
            <a href="{{ url()->previous() }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-title="Back">
                <i class="bi bi-arrow-left"></i>
            </a>
            <a href="{{ route('sysadmin.cms.page.edit', $page['id']) }}" class="btn btn-primary mx-2" data-bs-toggle="tooltip" data-bs-title="Edit">
                <i class="bi bi-pencil-fill"></i>
            </a>
            <a href="{{ route('sysadmin.cms.page.index') }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-title="List">
                <i class="bi bi-list"></i>
            </a>
        </div>
    </div>

    <div class="card p-1">
        {{-- Header --}}
        <div class="card-header p-3">
            <div class="row">
                <div class="col-12 border-bottom">
                    <h4 class="title mb-2">Page Details</h4>
                </div>

                <div class="col-md-8 mt-2">
                    <h1 class="fs-4 mb-1">{{ $page['title'] }}</h1>
                    <p class="mb-1"><strong>Description:</strong> {{ $page['description'] ?? '—' }}</p>
                    <p class="mb-0 text-primary">
                        <strong>Keywords:</strong> {{ $page['keywords'] ?? '—' }}
                    </p>
                </div>

                <div class="col-md-4 text-md-end mt-2">
                    @php
                        $statusClass = $page['status'] === 'active'
                            ? 'bg-success'
                            : 'bg-danger';
                    @endphp

                    <p class="mb-1">
                        <strong>Status:</strong>
                        <span class="badge {{ $statusClass }}">{{ ucfirst($page['status']) }}</span>
                    </p>
                    <p class="mb-0">
                        <strong>Last Updated:</strong>
                        {{ \Carbon\Carbon::parse($page['updated_at'])->format('d-m-Y H:i:s') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body p-3">

            {{-- Featured Image --}}
            @if(!empty($page['featured_image']))
                <div class="text-center mb-3">
                    <img
                        src="{{ asset(Modules\SysAdmin\Helpers\ImageUploader::getFilePath($page['featured_image'], $page['created_at'])) }}"
                        class="img-fluid rounded"
                        alt="{{ $page['title'] }}"
                    >
                </div>
            @endif

            {{-- Content --}}
            <div class="border rounded p-3">
                <h6 class="border-bottom pb-2 mb-3">Page Content</h6>
                <div class="content-body">
                    {!! html_entity_decode($page['content']) !!}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
