@extends('layouts.app')
@section('title', 'Confirm Password')
@section('content')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ url('/') }}">
                            <img id="logo" src="{{ asset('template/dist/assets/compiled/png/logo-dark.png') }}"
                                data-logo-dark="{{ asset('template/dist/assets/compiled/png/logo-white.png') }}"
                                data-logo-light="{{ asset('template/dist/assets/compiled/png/logo-dark.png') }}"
                                style="width: 300px; height: auto; margin-right:10%">
                        </a>
                    </div>
                    <h1 class="auth-title" style="color: #435EBE; font-weight: bold;">Confirm Password</h1>

                    <p class="auth-subtitle mb-5">This is a secure area of the application. Please confirm your password
                        before continuing.</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" id="password" name="password"
                                class="form-control form-control-xl @error('password') is-invalid @enderror" required
                                autocomplete="current-password" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5"
                                style="background-color: #435EBE; color: white;">{{ __('Confirm') }}</button>
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
