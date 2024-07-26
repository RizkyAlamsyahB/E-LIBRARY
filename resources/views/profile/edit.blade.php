@extends('layouts.app')
@section('title', 'Profil')
@section('main-content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Account Profile</h3>
            <p class="text-subtitle text-muted">A page where users can view their profile information</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <div class="avatar avatar-2xl position-relative">
                            <img id="avatarImage"
                                src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('template/dist/assets/compiled/jpg/user.png') }}"
                                alt="Image" class="rounded-circle avatar-image">
                        </div>
                        <h3 class="mt-3">{{ Auth::user()->name }}</h3>
                        <p class="text-small">{{ Auth::user()->department }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> Please check your input fields below.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Read-only Fields -->
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" id="name" class="form-control" value="{{ $user->name }}" >
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" id="email" class="form-control" value="{{ $user->email }}" >
                    </div>

                    <div class="form-group">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" id="department" class="form-control" value="{{ $user->department }}" >
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" id="phone" class="form-control" value="{{ $user->phone }}" >
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth" class="form-label">Birthday</label>
                        <input type="date" id="date_of_birth" class="form-control" value="{{ $user->date_of_birth }}"
                            >
                    </div>





                    <div class="form-group">
                        <label for="marital_status" class="form-label">Marital Status</label>
                        <input type="text" id="marital_status" class="form-control"
                            value="{{ ucfirst($user->marital_status) }}" >
                    </div>

                    <div class="form-group">
                        <label for="division" class="form-label">Division</label>
                        <input type="text" id="division" class="form-control"
                            value="{{ $user->division ? $user->division->name : 'N/A' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="subsections" class="form-label">Subsections</label>
                        <ul class="list-unstyled">
                            @forelse ($user->subsections as $subsection)
                                <li>{{ $subsection->name }}</li>
                            @empty
                                <li>No subsections assigned</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Update Password Form -->
                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="update_password_current_password"
                                class="form-label">{{ __('Current Password') }}</label>
                            <input type="password" name="current_password" id="update_password_current_password"
                                class="form-control" autocomplete="current-password">
                            @error('current_password')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                            <input type="password" name="password" id="update_password_password" class="form-control"
                                autocomplete="new-password">
                            @error('password')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="update_password_password_confirmation"
                                class="form-label">{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation"
                                id="update_password_password_confirmation" class="form-control"
                                autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary rounded-pill">{{ __('Save Changes') }}</button>
                        </div>
                    </form>

                    @if (session('status') === 'password-updated')
                        <p class="mt-2 text-sm text-gray-600">{{ __('Password updated successfully.') }}</p>
                    @endif

                    <!-- Form Delete Account -->
                    <form method="post" action="{{ route('profile.destroy') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('delete')

                        <div class="form-group">
                            <h2 class="text-lg font-medium text-gray-900">{{ __('Delete Account') }}</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="{{ __('Password') }}">
                            @error('password')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-3 rounded-pill"
                                onclick="event.preventDefault(); document.getElementById('delete-account-modal').classList.add('hidden');">{{ __('Cancel') }}</button>
                            <button type="submit"
                                class="btn btn-danger rounded-pill">{{ __('Delete Account') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        // Inisialisasi Flatpickr
        flatpickr("#date_of_birth", {
            dateFormat: "Y-m-d", // Format tanggal sesuai dengan yang Anda inginkan
            // Anda bisa menambahkan konfigurasi lainnya sesuai kebutuhan
        });
    </script>
@endsection
