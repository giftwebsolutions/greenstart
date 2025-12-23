@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Create Testimonial</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Testimonials</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="container-fluid">

    {{-- ERROR ALERT --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">

        {{-- LEFT COLUMN --}}
        <div class="col-md-12">
            <div class="card">
                <form id="create-testimonial"
                      class="theme-form"
                      method="POST"
                      enctype="multipart/form-data"
                      action="{{ route('sysadmin.testimonial.store') }}">
                    @csrf

                    <div class="card-body p-3">

                        {{-- NAME --}}
                        <div class="mb-3">
                            <label class="col-form-label">Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        {{-- CONTENT --}}
                        <div class="mb-3">
                            <label class="col-form-label">Testimonial</label>
                            <textarea name="content"
                                      rows="5"
                                      class="form-control @error('content') is-invalid @enderror"
                                      required>{{ old('content') }}</textarea>
                            @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        {{-- IMAGE --}}

                           
                        <div class="mb-3">
                            <label class="col-form-label">Image</label>
                            <input type="file"
                                   name="image"
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/*">
                            @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        {{-- IMAGE PREVIEW --}}
                        <div class="mb-3 text-center">
                            <img id="imagePreview"
                                 class="img-fluid rounded d-none"
                                 style="max-height:150px;">
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('sysadmin.testimonial.index') }}"
                           class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary mx-2">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

{{-- ================= SCRIPTS ================= --}}
@pushOnce('scripts')

{{-- JS VALIDATION --}}
{!! JsValidator::formRequest(
    'Modules\SysAdmin\Requests\TestimonialFormRequest',
    '#create-testimonial'
) !!}

{{-- IMAGE PREVIEW SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.querySelector('input[name="image"]');
        const preview = document.getElementById('imagePreview');

        if (!input || !preview) return;

        input.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endPushOnce
