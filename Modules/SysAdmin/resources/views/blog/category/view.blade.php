@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ $page['name'] }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Pages</li>
    <li class="breadcrumb-item active">View</li>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-start my-3">
                <div class="d-flex" role="group">
                    <a href="{{ url()->previous() }}"  data-bs-toggle="tooltip" data-bs-placement="top" adata-bs-title="back" class="btn btn-primary"><i
                            class="bi bi-arrow-left"></i></a>
                    <a href="{{ route('sysadmin.page.edit', $page['id']) }}" adata-bs-title="edit"  data-bs-toggle="tooltip" data-bs-placement="top" class="btn btn-primary mx-2"><i
                            class="bi bi-pencil-fill"></i></a>
                    <a href="{{ route('sysadmin.page.index') }}" adata-bs-title="list" data-bs-toggle="tooltip" data-bs-placement="top" class="btn btn-primary"><i class="bi bi-list"></i></a>
                </div>
            </div>
            <div class="col-12">
                <div class="card p-1">
                    <div class="card-header p-3">
                        <div class="row">
                            <div class="col-12 border-bottom">
                                <h4 class="title mb-2"> SEO Meta Tags</h4>
                            </div>
                            <div class="col-8 mt-2">
                                <h1 class="fs-4">{{ $page['title'] }}</h1>
                                <p>Description : {{ $page['description'] }}</p>
                                <p class="text-primary">Keywords : {{ $page['keywords'] }}</p>
                            </div>
                            <div class="col-4 text-end">
                                <p class="mt-2">Status: <span class="text-danger"> {{ $page['status'] }}</span></p>
                                <p>Last Updated: {{ date('d-m-Y H:i:s', strtotime($page['updated_at'])) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        @if ($page['featured_image'] !== null)
                            <div class="text-center">
                                <img src="{{ asset(Modules\SysAdmin\Helpers\ImageUploader::getFilePath($page['featured_image'], $page['created_at'])) }}"
                                    id="imgPreview" class="img-fluid rounded" alt="" />
                            </div>
                        @endif
                        <div class="border-bottom my-2"></div>
                        <p>{!! html_entity_decode($page['content']) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@pushOnce('scripts')
@endPushOnce
