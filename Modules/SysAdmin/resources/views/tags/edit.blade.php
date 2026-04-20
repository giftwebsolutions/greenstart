@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Edit Tag</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Blog</li>
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.blog.tags.index') }}">Tags</a></li>
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
                    <form id="edit-tag" class="theme-form" method="POST"
                          action="{{ route('sysadmin.blog.tags.update', $tag->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="card-body p-3">
                            <div class="mb-3">
                                <label class="col-form-label">Tag Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $tag->name) }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter tag name" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label text-muted">Slug</label>
                                <input type="text" class="form-control" value="{{ $tag->slug }}" disabled>
                                <small class="text-muted">Auto-generated from name on save.</small>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('sysadmin.blog.tags.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\TagFormRequest', '#edit-tag') !!}
@endPushOnce
