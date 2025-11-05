@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Create Content Block</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Blocks</li>
    <li class="breadcrumb-item active">Create</li>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card">
                    <form class="theme-form" id="create-block" method="POST" enctype="multipart/form-data"
                        action="{{ route('sysadmin.cms.block.create') }}">
                        @csrf
                        <div class="card-body p-3">

                            <div class="row mb-3">
                                <label for="title" class="col-md-12 col-form-label">{{ __('Title') }}</label>

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
                                <label for="key" class="col-md-12 col-form-label">{{ __('Key') }}</label>

                                <div class="col-md-12">
                                    <input id="key" type="text" placeholder="Key"
                                        class="form-control @error('key') is-invalid @enderror" name="key"
                                        value="{{ old('key') }}" required autocomplete="key" autofocus>

                                    @error('key')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label> Value </label>
                                <textarea class="form-control editor" id="content" placeholder="Enter the Content" rows="8" name="value">
                                     {{ old('value') }}
                                </textarea>
                                @error('value')
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
                        <h5>Icon</h5>
                    </div>
                    <div class="card-body p-3">
                        <input id="icon" type="text" placeholder="fa fa-pencil"
                            class="form-control @error('icon') is-invalid @enderror" name="icon"
                            value="{{ old('icon') }}" required autocomplete="icon">

                        @error('icon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-3">
                        <h5>Thumbnail</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <input type="file" class="form-control" name="thumbnail" id ="thumbnail" />
                            @error('thumbnail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <img src="" id="imgPreview" class="img-fluid" alt="" />
                            <div id="remove-image-block" class="my-2 text-center d-none">
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
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\BlockFormRequest', '#create-block') !!}
    <script type="module">
        let file;
        $('a#cancel-button').click(function() {
            window.location.href = "{{ route('sysadmin.cms.page.index') }}";
        });

        $('#thumbnail').change(function(e) {
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
            $('#thumbanil').val('');
            $("#imgPreview").attr("src", '');
            $('#remove-image-block').addClass('d-none')
        });

        
    </script>
@endPushOnce
