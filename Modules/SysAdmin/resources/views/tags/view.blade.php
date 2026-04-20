@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $tag['name'] }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Blog</li>
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.blog.tags.index') }}">Tags</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 my-3">
                <div class="d-flex gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i></a>
                    <a href="{{ route('sysadmin.blog.tags.edit', $tag['id']) }}" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
                    <a href="{{ route('sysadmin.blog.tags.index') }}" class="btn btn-primary"><i class="bi bi-list"></i></a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="150">ID</th>
                                <td>{{ $tag['id'] }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $tag['name'] }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{ $tag['slug'] }}</td>
                            </tr>
                            <tr>
                                <th>Created</th>
                                <td>{{ date('d-m-Y H:i', strtotime($tag['created_at'])) }}</td>
                            </tr>
                            <tr>
                                <th>Updated</th>
                                <td>{{ date('d-m-Y H:i', strtotime($tag['updated_at'])) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
