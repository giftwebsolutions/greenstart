@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/select2.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Edit Blog</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Blogs</li>
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
                    <form class="theme-form" id="update-blog" method="POST" enctype="multipart/form-data"
                        action="{{ route('sysadmin.blog.update', $blog->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="card-body p-3">

                            <div class="row mb-3">
                                <label for="title" class="col-md-12 col-form-label">{{ __('Blog Title') }}</label>

                                <div class="col-md-12">
                                    <input id="title" type="text" placeholder="Title"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title', $blog->title) }}" required autocomplete="title">

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="keywords" class="col-md-12 col-form-label">{{ __('Blog keywords') }}</label>

                                <div class="col-md-12">
                                    <input id="keywords" type="text" placeholder="keywords"
                                        class="form-control @error('keywords') is-invalid @enderror" name="keywords"
                                        value="{{ old('keywords', $blog->keywords) }}" autocomplete="keywords">

                                    @error('keywords')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label> Description </label>
                                <textarea class="form-control" id="description" placeholder="Enter the Description" rows="3" name="description">{{ old('description', $blog->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label> Content </label>
                                <textarea class="form-control editor" id="content" placeholder="Enter the Content" rows="8" name="content">
                                     {{ old('content', $blog->content) }}
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
                        <h5>Blog Status</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <select class="form-select" name="status" id="status">
                                <option>Select one</option>
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $blog->status ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group" id="datetimepicker" data-td-target-input="nearest"
                                    data-td-target-toggle="nearest">
                                    <input id="published_at" name="published_at" type="text"
                                        value="{{ $blog->published_at }}" class="form-control"
                                        data-td-target="#datetimepicker" />
                                    <span class="input-group-text" data-td-target="#datetimepicker"
                                        data-td-toggle="datetimepicker">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-3">
                        <h5>Tags</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <select class="form-select form-control-success-fill" name="tags" id="tag-select"
                                multiple></select>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header p-3">
                        <h5>Category</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <select class="form-select" name="category_id" id="category_id">
                                <option>Select Category</option>
                                @foreach ($parentCategory as $category)
                                    <option value="{{ $category['id'] }}"
                                        {{ $category['id'] == old('category_id', $blog->category_id) ? 'selected' : '' }}>
                                        {{ $category['name'] }}
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

                            @if ($blog->featured_image !== null)
                                <img src="{{ asset(Modules\SysAdmin\Helpers\ImageUploader::getFilePath($blog->featured_image, $blog->created_at, 'thumbnail')) }}"
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
    <script type="module" src="{{ asset('admin/js/select2/select2.full.min.js') }}"></script>
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\BlogFormRequest', '#update-blog') !!}
    <script type="module">
        let file;
        let published_at = '{{ $blog->published_at ?? date('d/m/Y h:m') }}';
        window.datetimepicker = new tempusDominus.TempusDominus(
            document.getElementById('datetimepicker'), {
                defaultDate: published_at,
                localization: {
                    locale: 'en',
                    format: 'dd/MM/yyyy HH:mm',
                }
            }
        );

        $('#tag-select').select2({
            tags: true,
            placeholder: "Select or create tags",
            data: [],
            tokenSeparators: [",", " "], // Separate tags with commas and spaces
            ajax: {
                url: "{{ route('sysadmin.blog.tags.search') }}", // Replace with your API endpoint
                dataType: 'json',
                delay: 250, // Delay search requests to avoid overwhelming server
                cache: false,
                processResults: function(data) {
                    return {
                        results: data.items.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
                        })
                    };
                },
                minimumInputLength: 3, // Minimum characters to trigger search
            },
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                };
            }
        });

        $('a#cancel-button').click(function() {
            window.location.href = "{{ route('sysadmin.blog.index') }}";
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
@section('script')
    <script type="module" src="{{ asset('admin/js/select2/select2.full.min.js') }}"></script>
@endsection
