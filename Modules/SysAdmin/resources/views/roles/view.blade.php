@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $role['name'] }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i></a>
                    <a href="{{ route('sysadmin.roles.edit', $role['id']) }}" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
                    <a href="{{ route('sysadmin.roles.index') }}" class="btn btn-primary"><i class="bi bi-list"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <table class="table table-bordered">
                            <tr><th width="150">ID</th><td>{{ $role['id'] }}</td></tr>
                            <tr><th>Name</th><td>{{ $role['name'] }}</td></tr>
                            <tr><th>Guard</th><td>{{ $role['guard_name'] }}</td></tr>
                            <tr><th>Created</th><td>{{ date('d-m-Y H:i', strtotime($role['created_at'])) }}</td></tr>
                            <tr><th>Updated</th><td>{{ date('d-m-Y H:i', strtotime($role['updated_at'])) }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
