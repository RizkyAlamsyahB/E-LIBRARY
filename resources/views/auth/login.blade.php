@extends('layouts.app')
@section('title', 'Login')
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
                <div class="container">
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
                        <h1 class="auth-title" style="color: #435EBE; font-weight: bold;">Log in.</h1>

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

                            <!-- CAPTCHA -->
                            <div class="d-flex align-items-center mt-2">
                                <img id="captcha-image" src="{{ captcha_src() }}" alt="captcha">
                                <a href="#" id="refresh-captcha" class="btn btn-link ms-2" style="color: #435EBE;">
                                    <i class="bi bi-arrow-clockwise"></i> Refresh
                                </a>


                            </div>
                            <div class="form-group position-relative has-icon-left mt-3">

                                <input type="text" name="captcha"
                                    class="form-control form-control-xl @error('captcha') is-invalid @enderror"
                                    placeholder="Captcha">
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                @error('captcha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>







                            <style>
                                .form-check-input:checked {
                                    background-color: #435EBE;
                                    border-color: #435EBE;
                                }

                                .form-check-input:focus {
                                    border-color: #435EBE;
                                    box-shadow: 0 0 0 0.2rem rgba(67, 94, 190, 0.25);
                                }
                            </style>

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
                            <p>
                                <a style="color: #435EBE; font-size:20px;" class="btn btn-link"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('refresh-captcha').addEventListener('click', function() {
            const captchaImage = document.getElementById('captcha-image');
            captchaImage.src = '{{ captcha_src() }}?' + new Date().getTime(); // Add timestamp to prevent caching
        });
    </script>
@endsection
