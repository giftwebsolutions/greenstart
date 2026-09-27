@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $definition['title'] }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ $definition['title'] }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        {!! $dataTable->table() !!}
    </div>
@endsection
