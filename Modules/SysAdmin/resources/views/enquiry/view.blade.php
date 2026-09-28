@extends('sysadmin::layouts.master')

@section('title', 'Enquiry Workspace')
@section('page-title', 'Enquiry Workspace')

@section('content')
    <livewire:sysadmin.enquiries.workspace :enquiry-id="$enquiry->id" />
@endsection
