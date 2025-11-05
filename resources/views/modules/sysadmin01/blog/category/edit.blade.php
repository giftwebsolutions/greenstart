@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Edit Blog Category</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Blog</li>
    <li class="breadcrumb-item">Category</li>
    <li class="breadcrumb-item active">Edit</li>
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
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card">
                    <form class="theme-form" id="update-category" method="POST" enctype="multipart/form-data"
                        action="{{ route('sysadmin.blog.category.update', $category->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="card-body p-3">
                            <div class="row mb-3">
                                <label for="name" class="col-md-12 col-form-label">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" type="text" placeholder="Category Name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $category->name }}" required autofocus>

                                    @error('name')
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
                                        value="{{ $category->keywords }}" autocomplete="keywords">

                                    @error('keywords')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label> Category Description </label>
                                <textarea class="form-control" id="description" placeholder="Enter the Description" rows="3" name="description">{{ $category->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label> Content </label>
                                <textarea class="form-control editor" id="content" placeholder="Enter the Content" rows="8" name="content">
                                     {{ $category->content }}
                                </textarea>
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
                        <h5>Category Status</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <select class="form-select" name="status" id="status">
                                <option>Select one</option>
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $value == $category->status ? 'selected' : '' }}>
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
                                        {{ $parent['id'] == $category->parent_id ? 'selected' : '' }}>
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
                                name="featured_image" id ="featured_image" />
                        </div>
                        <div class="mb-3">

                            @if ($category->featured_image !== null)
                                <img src="{{ asset(Modules\SysAdmin\Helpers\ImageUploader::getFilePath($category->featured_image, $category->created_at, 'thumbnail')) }}"
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
            </div>
            </form>
        </div>
    </div>
@endsection
@pushOnce('scripts')
    <script type="module" src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\PageFormRequest', '#update-category') !!}
    <script type="module">
        let file;
        $('a#cancel-button').click(function() {
            window.location.href = "{{ route('sysadmin.blog.category.index') }}";
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

        
    </script>
@endPushOnce
