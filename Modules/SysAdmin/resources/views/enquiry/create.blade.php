@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/select2.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Create Enquiry</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Enquiries</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Validation Errors --}}
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        {{-- Main Form --}}
        <div class="col-md-8">
            <div class="card">
                <form class="theme-form" id="create-enquiry"
                      method="POST"
                      action="{{ route('sysadmin.enquiry.store') }}">
                    @csrf

                    <div class="card-body p-3">

                        {{-- Customer Name --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Customer Name</label>
                            <div class="col-md-12">
                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter customer name"
                                       required>
                                @error('name')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Mobile --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Mobile Number</label>
                            <div class="col-md-12">
                                <input type="text"
                                       name="mobile"
                                       value="{{ old('mobile') }}"
                                       class="form-control @error('mobile') is-invalid @enderror"
                                       placeholder="Enter mobile number"
                                       required>
                                @error('mobile')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Email</label>
                            <div class="col-md-12">
                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Enter email address">
                                @error('email')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- City & State --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="col-form-label">City</label>
                                <input type="text"
                                       name="city"
                                       value="{{ old('city') }}"
                                       class="form-control @error('city') is-invalid @enderror">
                                @error('city')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="col-form-label">State</label>
                                <input type="text"
                                       name="state"
                                       value="{{ old('state') }}"
                                       class="form-control @error('state') is-invalid @enderror">
                                @error('state')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Category</label>
                            <div class="col-md-12">
                                <select name="category_id"
                                        class="form-select select2 @error('category_id') is-invalid @enderror"
                                        required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories ?? [] as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ (string)$id === (string)old('category_id') ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Product --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Product</label>
                            <div class="col-md-12">
                                <select name="product_id"
                                        class="form-select select2 @error('product_id') is-invalid @enderror"
                                        required>
                                    <option value="">Select Product</option>
                                    @foreach ($products ?? [] as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ (string)$id === (string)old('product_id') ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Qty / Price / Req Price --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="col-form-label">Quantity</label>
                                <input type="number" step="0.01" min="0"
                                       name="qty"
                                       value="{{ old('qty') }}"
                                       class="form-control @error('qty') is-invalid @enderror">
                                @error('qty')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label">Price</label>
                                <input type="number" step="0.01" min="0"
                                       name="price"
                                       value="{{ old('price') }}"
                                       class="form-control @error('price') is-invalid @enderror">
                                @error('price')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label">Requested Price</label>
                                <input type="number" step="0.01" min="0"
                                       name="req_price"
                                       value="{{ old('req_price') }}"
                                       class="form-control @error('req_price') is-invalid @enderror">
                                @error('req_price')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Message --}}
                        <div class="row mb-3">
                            <label class="col-md-12 col-form-label">Message</label>
                            <div class="col-md-12">
                                <textarea name="message"
                                          rows="4"
                                          class="form-control @error('message') is-invalid @enderror"
                                          placeholder="Customer enquiry details">{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="card-footer text-end">
                        <a href="javascript:void(0);" id="cancel-button" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary mx-2">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header p-3">
                    <label class="col-md-12 col-form-label">Status</label>
                </div>
                <div class="card-body p-3">
                    <select name="status"
                            id="status"
                            form="create-enquiry"
                            class="form-select @error('status') is-invalid @enderror"
                            required>
                        <option value="">Select status</option>
                       
                        @foreach ($statuses as $key => $value)
                            <option value="{{ $key }}"
                                {{ (string)$key === (string)old('status', 1) ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            {{-- Notes --}}
            <div class="card">
                <div class="card-header p-3">
                    <label class="col-md-12 col-form-label">Notes</label>
                </div>
                <div class="card-body p-3">
                    <p class="mb-0 small text-muted">
                        Enquiries are customer requests related to products.
                        Ensure mobile number and product details are correct
                        before saving.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@pushOnce('scripts')
<script type="module" src="{{ asset('admin/js/select2/select2.full.min.js') }}"></script>
{!! JsValidator::formRequest('Modules\SysAdmin\Requests\EnquiryFormRequest', '#create-enquiry') !!}
<script type="module">
    $('.select2').select2({ width: '100%' });

    $('#cancel-button').on('click', function () {
        window.location.href = "{{ route('sysadmin.enquiry.index') }}";
    });
</script>
@endPushOnce
