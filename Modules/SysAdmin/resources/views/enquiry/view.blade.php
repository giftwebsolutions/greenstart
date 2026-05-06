@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ $enquiry->name }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Enquiries</li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- Action buttons --}}
            <div class="col-12 text-start my-3">
                <div class="d-flex" role="group">
                    <a href="{{ url()->previous() }}" data-bs-toggle="tooltip" data-bs-placement="top"
                       data-bs-title="Back" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <a href="{{ route('sysadmin.enquiry.index') }}" data-bs-toggle="tooltip"
                       data-bs-placement="top" data-bs-title="List" class="btn btn-primary mx-2">
                        <i class="bi bi-list"></i>
                    </a>
                </div>
            </div>

            <div class="col-12">
                <div class="card p-1">

                    {{-- Header / meta --}}
                    <div class="card-header p-3">
                        <div class="row">
                            <div class="col-12 border-bottom">
                                <h4 class="title mb-2">Enquiry Details</h4>
                            </div>

                            <div class="col-md-8 mt-2">
                                <h1 class="fs-4 mb-1"><strong>Name:</strong> {{ $enquiry->name }}</h1>

                                <div class="mt-2">
                                    <p class="mb-1">
                                        <strong>Email:</strong> {{ $enquiry->email ?? '—' }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-4 text-md-end mt-2">
                                @if(!empty($enquiry->created_at))
                                    <p class="mb-0">
                                        <strong>Created:</strong>
                                        {{ \Carbon\Carbon::parse($enquiry->created_at)->format('d-m-Y H:i:s') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-3">
                        <div class="row">

                            {{-- Subject --}}
                            <div class="col-12">
                                <div class="border rounded p-3 mb-3">
                                    <h6 class="border-bottom pb-2 mb-3">Subject</h6>

                                    @if(!empty($enquiry->message))
                                        <p class="mb-0" style="white-space: pre-line;">{{ $enquiry->subject }}</p>
                                    @else
                                        <p class="mb-0 text-muted">—</p>
                                    @endif
                                </div>
                            </div>

                           
                            {{-- Message --}}
                            <div class="col-12">
                                <div class="border rounded p-3 mb-3">
                                    <h6 class="border-bottom pb-2 mb-3">Message</h6>

                                    @if(!empty($enquiry->message))
                                        <p class="mb-0" style="white-space: pre-line;">{{ $enquiry->message }}</p>
                                    @else
                                        <p class="mb-0 text-muted">—</p>
                                    @endif
                                </div>
                            </div>

                        </div>

                        {{-- Future: show json/meta if needed --}}
                        {{-- <pre class="mt-3">{{ json_encode($enquiry->toArray(), JSON_PRETTY_PRINT) }}</pre> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@pushOnce('scripts')
@endPushOnce
