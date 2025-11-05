@extends('sysadmin::layouts.auth')
@section('title', 'Login')

@section('css')
@endsection

@section('style')
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5 bg-light align-middle"><img class="bg-img-cover img-fluid" src="{{ asset('admin/images/login/bg.png') }}"
                    alt="looginpage"></div>
            <div class="col-xl-7 p-0">
                <div class="login-card">
                    <div>
                        {{-- <div><a class="logo text-start" href="{{ route('sysadmin.index') }}"><img class="img-fluid for-light"
                                    src="{{ asset('admin/images/logo/login.png') }}" alt="looginpage"><img
                                    class="img-fluid for-dark" src="{{ asset('admin/images/logo/logo_dark.png') }}"
                                    alt="looginpage"></a>
                        </div> --}}
                        <div class="login-main">
                            <form method="POST" class="theme-form" action="{{ route('sysadmin.login.form') }}">
                                @csrf
                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>

                                <div class="form-group">
                                    <label class="col-form-label">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>

                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('Login') }}
                                        </button>

                                        @if (Route::has('sysadmin.password.request'))
                                            <a class="btn btn-link" href="{{ route('sysadmin.password.request') }}">
                                                {{ __('Forgot Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
