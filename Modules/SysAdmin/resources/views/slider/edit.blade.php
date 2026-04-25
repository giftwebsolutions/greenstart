@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Edit Slider</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Media</li>
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.slider.index') }}">Sliders</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="container-fluid">

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
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <form id="edit-slider" class="theme-form" method="POST" enctype="multipart/form-data"
                          action="{{ route('sysadmin.slider.update', $slider->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="card-header p-3">
                            <h5>Slider Details</h5>
                        </div>

                        <div class="card-body p-3">

                            <div class="mb-3">
                                <label class="col-form-label">Slider Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $slider->name) }}"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label">Description</label>
                                <textarea name="description" rows="3"
                                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $slider->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ $slider->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $slider->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label">Thumbnail</label>
                                <input type="file" name="thumbnail" id="thumbnail"
                                       class="form-control @error('thumbnail') is-invalid @enderror"
                                       accept="image/jpg,image/jpeg,image/png">
                                @error('thumbnail')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                @if($slider->thumbnail)
                                    <div class="mt-2">
                                        <img id="thumbnailPreview"
                                             src="{{ asset('storage/' . $slider->thumbnail) }}"
                                             class="img-fluid rounded" style="max-height:150px;">
                                    </div>
                                @else
                                    <img id="thumbnailPreview" class="img-fluid rounded d-none mt-2" style="max-height:150px;">
                                @endif
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('sysadmin.slider.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\SliderFormRequest', '#edit-slider') !!}
    <script>
        document.getElementById('thumbnail').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById('thumbnailPreview');
                img.src = e.target.result;
                img.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });
    </script>
@endPushOnce
