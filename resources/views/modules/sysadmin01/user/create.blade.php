@extends('sysadmin::layouts.master')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Create User</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">User</li>
    <li class="breadcrumb-item active">Create</li>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" id="user-create" method="POST" action="{{ route('sysadmin.user.create') }}">
                        @csrf
                        <div class="card-header">
                            <h5>{{ __('User Creation') }}</h5>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-9">
                                    <input id="name" type="text" placeholder="Username"
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
                                <label for="email"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-9">
                                    <input id="email" type="email" placeholder="Email Address"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-9">
                                    <input id="password" type="password" placeholder="Password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-9">
                                    <input id="password-confirm" type="password" class="form-control"
                                        placeholder="Confirm Password" name="password_confirmation" required
                                        autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <a href="javascript:void(0);" id="cancel-button" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\UserFormRequest', '#user-create') !!}
    <script type="module">
        $('a#cancel-button').click(function() {
            window.location.href = "{{ route('sysadmin.user.index') }}";
        });
    </script>
@endPushOnce
