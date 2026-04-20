@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Manage Tags</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Blog</li>
    <li class="breadcrumb-item active">Tags</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
@endsection
