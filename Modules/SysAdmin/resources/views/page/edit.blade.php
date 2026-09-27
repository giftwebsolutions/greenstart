@extends('sysadmin::layouts.master')

@section('title', 'Edit Page')
@section('page-title', 'Edit Page')

@section('content')
    @include('sysadmin::page._form', ['page' => $page])
@endsection
