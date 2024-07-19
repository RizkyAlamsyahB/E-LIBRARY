@extends('layouts.app')

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
                    <h1 class="auth-title" style="color: #435EBE; font-weight: bold;">Forgot Password</h1>

                    <p class="auth-subtitle mb-5">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" id="email" name="email"
                                class="form-control form-control-xl @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5"
                                style="background-color: #435EBE; color: white;">{{ __('Email Password Reset Link') }}</button>
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
