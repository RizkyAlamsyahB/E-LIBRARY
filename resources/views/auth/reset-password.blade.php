@extends('layouts.app')
@section('title', 'Reset Password')
@section('content')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('template/dist/assets/compiled/png/logo.png') }}" alt="Logo" style="width: 150px; height: auto;">
                        </a>
                    </div>
                    <h1 class="auth-title" style="color: #435EBE; font-weight: bold;">Reset Password</h1>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" id="email" name="email"
                                class="form-control form-control-xl @error('email') is-invalid @enderror"
                                value="{{ old('email', $request->email) }}" required autocomplete="username" autofocus placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" id="password" name="password"
                                class="form-control form-control-xl @error('password') is-invalid @enderror"
                                required autocomplete="new-password" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control form-control-xl @error('password_confirmation') is-invalid @enderror"
                                required autocomplete="new-password" placeholder="Confirm Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5"
                                style="background-color: #435EBE; color: white;">{{ __('Reset Password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>
@endsection
