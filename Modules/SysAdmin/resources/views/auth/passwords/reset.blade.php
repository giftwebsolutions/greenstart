@extends('sysadmin::layouts.auth')

@section('content')
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5"><img class="bg-img-cover bg-center" src="{{ asset('admin/images/login/3.jpg') }}"
                        alt="looginpage"></div>
                <div class="col-xl-7 p-0">
                    <div class="login-card">
                        <div>
                            <div><a class="logo text-start" href="{{ route('sysadmin.index') }}"><img
                                        class="img-fluid for-light" src="{{ asset('admin/images/logo/login.png') }}"
                                        alt="looginpage"><img class="img-fluid for-dark"
                                        src="{{ asset('admin/images/logo/logo_dark.png') }}" alt="looginpage"></a>
                            </div>
                            <div class="login-main">
                                <form method="POST" action="{{ route('sysadmin.password.update') }}">
                                    @csrf

                                    <h4>Reset Your Password</h4>
                                    <p>Enter your email here</p>

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="row mb-3">
                                        <label for="email"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ $email ?? old('email') }}" required autocomplete="email"
                                                autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password"
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
                                            class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Reset Password') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
