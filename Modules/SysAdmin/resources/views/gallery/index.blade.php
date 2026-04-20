@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Manage Galleries</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Media</li>
    <li class="breadcrumb-item active">Galleries</li>
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
