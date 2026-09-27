@extends('sysadmin::layouts.master')

@section('title', 'Edit Blog Category')
@section('page-title', 'Edit Blog Category')

@section('content')
    @include('sysadmin::blog.category._form', ['category' => $category])
@endsection
