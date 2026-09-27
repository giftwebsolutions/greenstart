@extends('sysadmin::layouts.master')

@section('title', 'Edit Blog Post')
@section('page-title', 'Edit Blog Post')

@section('content')
    @include('sysadmin::blog._form', ['blog' => $blog])
@endsection
