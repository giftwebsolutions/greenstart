@extends('sysadmin::layouts.master')

@section('title', 'Create Blog Category')
@section('page-title', 'Create Blog Category')

@section('content')
    @include('sysadmin::blog.category._form')
@endsection
