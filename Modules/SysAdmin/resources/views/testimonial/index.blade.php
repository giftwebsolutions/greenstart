@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Testimonials</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Testimonials</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
<div class="container-fluid">

    {{-- SUCCESS MESSAGE --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

</div>
@endsection

{{-- ================= SCRIPTS ================= --}}
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
