@php
    // /dd($page);
@endphp

@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
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
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card">
                    <form class="theme-form" id="update-page" method="POST" enctype="multipart/form-data"
                        action="{{ route('sysadmin.cms.page.update', $page->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="card-body p-3">
                            <div class="row mb-3">
                                <label for="name" class="col-md-12 col-form-label">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" type="text" placeholder="Page Name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $page->name }}" required autofocus>

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
                                        value="{{ $page->title }}" required>

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
                                        value="{{ $page->keywords }}" autocomplete="keywords">

                                    @error('keywords')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label> Description </label>
                                <textarea class="form-control" id="description" placeholder="Enter the Description" rows="3" name="description">{{ $page->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label> Content </label>

                                <div class="editor" data-name="content">{!! old('content', $page->content ?? '') !!}</div>
                                <input type="hidden" name="content" value="{{ old('content', $page->content ?? '') }}">

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
                                    <option value="{{ $key }}" {{ $key == $page->status ? 'selected' : '' }}>
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
                                        {{ $parent['id'] == $page->parent_id ? 'selected' : '' }}>
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
                            @error('featured_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                name="featured_image" id="featured_image" />
                        </div>
                        <div class="mb-3">

                            @if ($page->featured_image !== null)
                                <img src="{{ asset(Modules\SysAdmin\Helpers\ImageUploader::getFilePath($page->featured_image, $page->created_at, 'thumbnail')) }}"
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

                <div class="card">
                    <div class="card-header p-3">
                        <h5>Banner Image</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <input type="file" class="form-control" name="banner" id="banner" />
                        </div>
                        <div class="mb-3">
                            @if ($page->banner !== null)
                                @php
                                    //echo $page->banner . 'test' . $page->created_at;
                                @endphp
                                <img src="{{ asset(Modules\SysAdmin\Helpers\ImageUploader::getFilePath($page->banner, $page->created_at, 'thumbnail')) }}"
                                    id="bannerPreview" class="img-fluid" alt="" />
                            @else
                                <img src="" id="bannerPreview" class="img-fluid" alt="" />
                            @endif

                            <div id="remove-banner-image" class="my-2 text-center">
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
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\PageFormRequest', '#update-page') !!}
    <script type="module">
        let file;
        $('a#cancel-button').click(function() {
            window.location.href = "{{ route('sysadmin.cms.page.index') }}";
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
