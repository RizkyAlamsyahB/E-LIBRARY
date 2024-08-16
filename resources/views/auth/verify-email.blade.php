@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('main-content')
    <div class="page-content" style="display: none;">
        <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 50vh;">
            <div class="row justify-content-center">
                <div class="text-center">
                    @if (session('resent'))
                        <div class="alert alert-success alert-dismissible fade show position-fixed rounded-pill"
                            style="bottom: 1rem; right: 1rem; z-index: 1050; max-width: 90%; width: auto;" role="alert">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show position-fixed rounded-pill"
                            style="bottom: 1rem; right: 1rem; z-index: 1050; max-width: 90%; width: auto;" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h1 class="mb-4">{{ __('Verifikasi Alamat Email Anda') }}</h1>
                    <p class="mb-4">
                        {{ __('Sebelum melanjutkan, harap verifikasi email Anda dengan klik tombol verifikasi ini.') }}</p>
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
    </div>
    <style>

    </style>
    <script>
        // Menambahkan efek fade out pada alert setelah 2 detik
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            });
        }, 2000); // 2000 ms = 2 detik
    </script>
@endsection
