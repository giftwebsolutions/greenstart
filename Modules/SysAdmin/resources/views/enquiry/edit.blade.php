@extends('sysadmin::layouts.master')

@section('title', 'Edit Enquiry')
@section('page-title', 'Edit Enquiry')

@section('content')
    @include('sysadmin::enquiry._form', ['enquiry' => $enquiry])
@endsection
