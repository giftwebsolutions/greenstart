@php
    use Modules\SysAdmin\Helpers\ImageUploader;
@endphp
@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $slider['name'] }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Media</li>
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.slider.index') }}">Sliders</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i></a>
                    <a href="{{ route('sysadmin.slider.edit', $slider['id']) }}" class="btn btn-primary"><i
                            class="bi bi-pencil-fill"></i></a>
                    <a href="{{ route('sysadmin.slider.index') }}" class="btn btn-primary"><i class="bi bi-list"></i></a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary"><i
                            class="bi bi-plus"></i>Add</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <table class="table table-bordered">
                            <tr>
                                <th>Status</th>
                                <td>{{ $slider['status'] == 1 ? 'Active' : 'Inactive' }}</td>
                            </tr>
                            @if ($slider['description'])
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $slider['description'] }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            @if ($slider['thumbnail'])
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header p-3">
                            <h5>Thumbnail</h5>
                        </div>
                        <div class="card-body text-center p-3">
                            <img src="{{ ImageUploader::getFilePath($slider['thumbnail'], $slider['created_at'], 'thumbnail') }}"
                                class="img-fluid rounded" style="max-height:200px;">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <table class="table table-bordered" id="slider-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Slider_image</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($slider['slider_items'] as $item)
                                <tr>
                                    <td class="w-40">{{ $item['description'] }}</td>
                                    <td class="w-50"><img id="thumbnailPreview"
                                            src="{{ ImageUploader::getFilePath($item['file'], $item['created_at']) }}"
                                            class="img-fluid rounded" style="max-height:150px;"></td>
                                    <td>
                                        <form enctype="multipart/form-data"
                                            action="{{ route('sysadmin.slider.item-delete', $item['id']) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<br><br>
<div class="modal modal-lg fade" id="myModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header w-100">
                <h5 class="modal-title">Add Slider Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
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
                    <form method="post" class="theme-form" enctype="multipart/form-data" id="slider-item"
                    action="{{ route('sysadmin.slider.item-create', $slider['id']) }}">
                        @csrf
                        <input type="text" class="form-control mb-2" name="slider_id" value="{{ $slider['id'] }}"
                                placeholder="slider_id" hidden>
                        <input type="text" class="form-control mb-2" name="title" placeholder="title" required>
                        <input type="text" class="form-control mb-2" name="path" placeholder="path">
                        <select class="form-control mb-2" name="target" id="">
                        <option value="">Select Target</option>
                        <option value="_self">self</option>
                        <option value="_blank">blank</option>
                        </select>
                        <input type="text" class="form-control mb-2" name="description" placeholder="description">

                        <small class="test-muted">Required-image-size *1200x400*</small>
                        <input name="file" type="file" class="form-control mb-2" required placeholder="1200 x 400">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                <!-- Footer -->
                <div class="modal-footer">
                </div>
            </div>

        </div>
    </div>
</div>

@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\SliderFormRequest', '#slider-item') !!}
    <script>
        document.getElementById('thumbnail').addEventListener('change', function() {
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
