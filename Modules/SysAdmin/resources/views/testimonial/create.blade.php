@extends('sysadmin::layouts.master')

@section('title', 'Add Testimonial')
@section('page-title', 'Add Testimonial')

@section('content')
    <livewire:sysadmin.testimonials.workspace :start-creating="true" />
@endsection
