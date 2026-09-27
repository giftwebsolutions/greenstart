@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $definition['title'] }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ $definition['title'] }}</li>
@endsection

@section('content')
    <livewire:sysadmin.resource-table :resource="$resource" />
@endsection
