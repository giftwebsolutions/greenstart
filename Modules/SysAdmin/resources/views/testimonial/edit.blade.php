
@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Edit Testimonial</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Testimonials</li>
    <li class="breadcrumb-item active">Edit</li>
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

        {{-- MAIN COLUMN --}}
        <div class="col-md-12">
            <div class="card">
                <form id="update-testimonial"
                      class="theme-form"
                      method="POST"
                      enctype="multipart/form-data"
                      action="{{ route('sysadmin.testimonial.update', $testimonial->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="card-body p-3">

                        {{-- NAME --}}
                        <div class="mb-3">
                            <label class="col-form-label">Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $testimonial->name) }}"
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
                                      required>{{ old('content', $testimonial->content) }}</textarea>
                            @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        {{-- IMAGE --}}

                        <div class="card-body p-3">
                        <div class="mb-3">
                            
                            @error('image')
                            
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image" id="image" />
                        </div>
                        <div class="mb-3">

                            @if ($testimonial->image !== null)
                                <img src="{{ asset(Modules\SysAdmin\Helpers\ImageUploader::getFilePath($testimonial->image, $testimonial->created_at, 'thumbnail')) }}"
                                    id="imgPreview" class="img-fluid" alt="" />
                            @else
                                <img src="" id="imgPreview" class="img-fluid" alt="" />
                            @endif

                            <div id="remove-image-block" class="my-2 text-center">
                                <a href="javascript:void(0)" id="remove-image" class="btn btn-danger">Remove</a>
                            </div>
                        </div>
                    </div>
                    

                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('sysadmin.testimonial.index') }}"
                           class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary mx-2">
                            Update
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
    '#update-testimonial'
) !!}

{{-- IMAGE PREVIEW SCRIPT --}}
 <script type="module">
   
      $('#image').change(function (e) {
           var file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $("#imgPreview")
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
                $('#remove-image-block').removeClass('d-none');
            }
        });

        $('#remove-image').click(function () {
            file = '';
            $('#image').val('');
            $("#imgPreview").attr("src", '');
            $('#remove-image-block').addClass('d-none')
        });

</script>
@endPushOnce
