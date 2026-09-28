@extends('sysadmin::layouts.master')

@section('title', 'Edit Testimonial')
@section('page-title', 'Edit Testimonial')

@section('content')
    <livewire:sysadmin.testimonials.workspace :testimonial-id="$testimonial->id" />
@endsection
