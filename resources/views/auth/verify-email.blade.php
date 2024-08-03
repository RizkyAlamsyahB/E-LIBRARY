@extends('layouts.app')
@section('title', 'Verifikasi Email')
@section('main-content')
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 50vh;">
        <div class="row justify-content-center">
            <div class="text-center">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                    </div>
                @endif

                <h1 class="mb-4">{{ __('Verifikasi Alamat Email Anda') }}</h1>
                <p class="mb-4">{{ __('Sebelum melanjutkan, harap verifikasi email Anda dengan klik tombol verifikasi ini.') }}</p>
                <p>{{ __('Jika Anda tidak menerima email tersebut') }},
                <form method="POST" action="{{ route('verification.send') }}" class="mb-2">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        {{ __('Kirim Email Verifikasi') }}
                    </button>
                </form>
                </p>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mt-4">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection
