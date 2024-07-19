@extends('layouts.app')
@section('content')
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                swal({
                    title: "Success!",
                    text: "{{ session('status') }}",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ url('/') }}"><img src=".{{ asset('template/dist/assets/compiled/png/logo.png') }}"
                                alt="Logo" style="width: 150px; height: auto;"></a>
                    </div>
                    <h1 class="auth-title" style="color: #435EBE; font-weight: bold;">Log in.</h1>

                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" id="email" name="email"
                                class="form-control form-control-xl @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-gray-600" for="remember">
                                Keep me logged in
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5"
                            style="background-color: #435EBE; color: white;">{{ __('Login') }}</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        {{-- <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-bold"
                            style="color: #435EBE;">Sign
                            up</a>.</p> --}}
                        <p>
                            <a style="color: #435EBE; font-size:20px;" class="btn btn-link"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>
@endsection
