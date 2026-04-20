@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Create Role</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Create</li>
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
                    <form id="create-role" class="theme-form" method="POST"
                          action="{{ route('sysadmin.roles.store') }}">
                        @csrf

                        <div class="card-body p-3">

                            <div class="mb-3">
                                <label class="col-form-label">Role Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="e.g. Editor, Moderator" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label">Guard Name <span class="text-danger">*</span></label>
                                <select name="guard_name" class="form-select @error('guard_name') is-invalid @enderror">
                                    <option value="web" {{ old('guard_name', 'web') === 'web' ? 'selected' : '' }}>web</option>
                                    <option value="api" {{ old('guard_name') === 'api' ? 'selected' : '' }}>api</option>
                                </select>
                                @error('guard_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('sysadmin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\RoleFormRequest', '#create-role') !!}
@endPushOnce
