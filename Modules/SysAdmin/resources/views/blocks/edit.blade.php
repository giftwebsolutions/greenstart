@extends('sysadmin::layouts.master')

@section('title', 'Edit Content Block')
@section('page-title', 'Edit Content Block')

@section('content')
    @include('sysadmin::blocks._form', ['block' => $block])
@endsection
