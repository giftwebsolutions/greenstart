@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Create Page</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Pages</li>
    <li class="breadcrumb-item active">Create</li>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <form class="theme-form" id="create-page" method="POST" enctype="multipart/form-data"
                        action="{{ route('sysadmin.page.create') }}">
                        @csrf

                        <div class="card-body p-3">
                            <div class="row mb-3">
                                <label for="name" class="col-md-12 col-form-label">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" type="text" placeholder="Page Name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="title" class="col-md-12 col-form-label">{{ __('Page Title') }}</label>

                                <div class="col-md-12">
                                    <input id="title" type="text" placeholder="Title"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title') }}" required autocomplete="title">

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="keywords" class="col-md-12 col-form-label">{{ __('Page keywords') }}</label>

                                <div class="col-md-12">
                                    <input id="keywords" type="text" placeholder="keywords"
                                        class="form-control @error('keywords') is-invalid @enderror" name="keywords"
                                        value="{{ old('keywords') }}" autocomplete="keywords">

                                    @error('keywords')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label> Description </label>
                                <textarea class="form-control" id="description" placeholder="Enter the Description" rows="3" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label> Content </label>
                                <textarea class="form-control editor" id="content" placeholder="Enter the Content" rows="8" name="content">{{ old('content') }}</textarea>
                                @error('Content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <a href="javascript:void(0);" id="cancel-button" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Submit</button>
                        </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header p-3">
                        <h5>Page Status</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <select class="form-select" name="status" id="status">
                                <option>Select one</option>
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}" {{ $key == 1 ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-3">
                        <h5>Parent</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                             <select class="form-select" name="parent_id" id="parent_id">
                                <option value="0">Select Parent</option>
                                @foreach ($parents as $parent)
                                    <option value="{{ $parent['id'] }}"
                                        {{ $parent['id'] == old('parent_id') ? 'selected' : '' }}>
                                        {{ $parent['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-3">
                        <h5>Feature Image</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <input type="file" class="form-control" name="featured_image" id ="featured_image" />
                        </div>
                        <div class="mb-3">
                            <img src="" id="imgPreview" class="img-fluid" alt="" />
                            <div id="remove-image-block" class="my-2 text-center d-none">
                                <a href="javascript:void(0)" id="remove-image" class="btn btn-danger">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-3">
                        <h5>Banner Image</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <input type="file" class="form-control" name="banner" id ="banner" />
                        </div>
                        <div class="mb-3">
                            <img src="" id="bannerPreview" class="img-fluid" alt="" />
                            <div id="remove-banner-image" class="my-2 text-center d-none">
                                <a href="javascript:void(0)" id="remove-banner" class="btn btn-danger">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </form>
        </div>
    </div>
@endsection
@pushOnce('scripts')
    <script type="module" src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script type="module" src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script type="module" src="{{ asset('admin/js/select2/select2.full.min.js') }}"></script>
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\PageFormRequest', '#create-page') !!}
    <script type="module">
        let file;
        $('a#cancel-button').click(function() {
            window.location.href = "{{ route('sysadmin.page.index') }}";
        });

        $('#featured_image').change(function(e) {
            file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $("#imgPreview")
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
                $('#remove-image-block').removeClass('d-none');
            }
        });

        $('#remove-image').click(function() {
            file = '';
            $('#featured_image').val('');
            $("#imgPreview").attr("src", '');
            $('#remove-image-block').addClass('d-none')
        });

        $('#banner').change(function(e) {
            file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $("#bannerPreview")
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
                $('#remove-banner-image').removeClass('d-none');
            }
        });

        $('#remove-banner').click(function() {
            file = '';
            $('#banner').val('');
            $("#bannerPreview").attr("src", '');
            $('#remove-banner-image').addClass('d-none')
        });

        
    </script>
@endPushOnce
