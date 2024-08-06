@extends('layouts.app')
@section('title', 'Forgot Password')
@section('content')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div class="row justify-content-center mt-5">
                    <div class="col-auto">
                        <a href="{{ url('/') }}">
                            <img id="logo" src="{{ asset('template/dist/assets/compiled/png/LOGO BAWASLU.png') }}"
                                data-logo-dark="{{ asset('template/dist/assets/compiled/png/Logo Bawaslu Putih.png') }}"
                                data-logo-light="{{ asset('template/dist/assets/compiled/png/LOGO BAWASLU.png') }}"
                                style="width: 300px; height: auto;">
                        </a>
                    </div>
                </div>
                <div id="auth-left">

                    <h1 class="auth-title" style="color: #435EBE; font-weight: bold;">Forgot Password</h1>

                    

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
