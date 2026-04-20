@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $page['name'] }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Media</li>
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.media.slider.index') }}">Sliders</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i></a>
                    <a href="{{ route('sysadmin.media.slider.edit', $page['id']) }}" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
                    <a href="{{ route('sysadmin.media.slider.index') }}" class="btn btn-primary"><i class="bi bi-list"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <table class="table table-bordered">
                            <tr><th width="150">ID</th><td>{{ $page['id'] }}</td></tr>
                            <tr><th>Name</th><td>{{ $page['name'] }}</td></tr>
                            <tr><th>Slug</th><td>{{ $page['slug'] }}</td></tr>
                            <tr><th>Status</th><td>{{ $page['status'] == 1 ? 'Active' : 'Inactive' }}</td></tr>
                            @if($page['description'])
                            <tr><th>Description</th><td>{{ $page['description'] }}</td></tr>
                            @endif
                            <tr><th>Created</th><td>{{ date('d-m-Y H:i', strtotime($page['created_at'])) }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            @if($page['thumbnail'])
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header p-3"><h5>Thumbnail</h5></div>
                    <div class="card-body text-center p-3">
                        <img src="{{ asset('storage/' . $page['thumbnail']) }}"
                             class="img-fluid rounded" style="max-height:200px;">
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
