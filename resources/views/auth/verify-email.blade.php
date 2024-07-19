@extends('layouts.app')
@section('title', 'Verify Email')
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
                    <h1 class="auth-title" style="color: #435EBE; font-weight: bold;">Verify Email</h1>

                    <div class="mb-4 text-sm text-gray-600">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <div class="mt-4 flex items-center justify-between">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5"
                                style="background-color: #435EBE; color: white;">
                                {{ __('Resend Verification Email') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="btn btn-link text-sm text-gray-600 hover:text-gray-900">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>
@endsection
