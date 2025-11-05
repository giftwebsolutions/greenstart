@extends('sysadmin::layouts.master')
@section('title', 'File Manager')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>File Manager</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Home</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row widget-grid">
            <div class="col-12">
                <div id="fm" style="height: 600px;"></div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endsection
