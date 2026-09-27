@extends('sysadmin::layouts.master')

@section('title', 'Create Blog Post')
@section('page-title', 'Create Blog Post')

@section('content')
    @include('sysadmin::blog._form')
@endsection
