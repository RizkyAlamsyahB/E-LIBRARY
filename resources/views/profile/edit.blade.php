@extends('layouts.app')
@section('main-content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Account Profile</h3>
            <p class="text-subtitle text-muted">A page where users can change profile information</p>
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
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <style>
                            .avatar-2xl:hover .avatar-image {
                                opacity: 0.4;
                            }
                        </style>

                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl position-relative">
                                <img id="avatarImage"
                                    src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('template/dist/assets/compiled/jpg/user.png') }}"
                                    alt="Image" class="rounded-circle avatar-image">
                                <input type="file" name="photo" id="photo" class="form-control file-input"
                                    onchange="previewImage(event)" hidden>
                                <label for="photo" class="file-input-label">
                                    <i class="bi bi-pencil-fill pencil-icon position-absolute top-100 start-100 translate-middle"
                                        style="font-size:20px; cursor: pointer;"></i>
                                </label>
                                @error('photo')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <h3 class="mt-3">{{ Auth::user()->name }}</h3>
                            <p class="text-small">{{ Auth::user()->department }}</p>

                        </div>

                        <script>
                            function previewImage(event) {
                                const reader = new FileReader();
                                reader.onload = function() {
                                    const output = document.getElementById('avatarImage');
                                    output.src = reader.result;
                                }
                                reader.readAsDataURL(event.target.files[0]);
                            }
                        </script>
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
                    <!-- Form Update Profile -->
                    {{-- <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put') --}}

                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        {{-- @error('name')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror --}}
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email', $user->email) }}" required autocomplete="username">
                        {{-- @error('email')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror --}}

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800">
                                    {{ __('Your email address is unverified.') }}

                                    <button form="send-verification"
                                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" name="department" id="departement" class="form-control"
                            value="{{ old('phone', $user->department) }}" placeholder="Your department">

                        @error('department')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                            value="{{ old('phone', $user->phone) }}" placeholder="Your Phone">

                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="date_of_birth" class="form-label">Birthday</label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            class="form-control mb-3 flatpickr-no-config""
                            value="{{ old('date_of_birth', $user->date_of_birth) }}" placeholder="Select date..">

                    </div>

                    <div class="form-group">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>
                                Male</option>
                            <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>
                                Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" class="form-control" placeholder="Your Address">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="marital_status" class="form-label">Marital Status</label>
                        <select name="marital_status" id="marital_status" class="form-control">
                            <option value="">Select Marital Status</option>
                            <option value="single"
                                {{ old('marital_status', $user->marital_status) === 'single' ? 'selected' : '' }}>
                                Single</option>
                            <option value="married"
                                {{ old('marital_status', $user->marital_status) === 'married' ? 'selected' : '' }}>
                                Married</option>
                        </select>
                    </div>

                    {{-- <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" name="role" id="role" class="form-control"
                            value="{{ old('role', $user->role) }}" placeholder="Your role" disabled>
                    </div> --}}


                    <div class="form-group">
                        <button type="submit" class="btn btn-primary rounded-pill">{{ __('Save Changes') }}</button>
                    </div>
                    </form>

                    <!-- Form for Email Verification Resend -->
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    @if (session('status') === 'profile-updated')
                        <p class="mt-2 text-sm text-gray-600">{{ __('Profile updated successfully.') }}</p>
                    @endif

                    <!-- Form Update Password -->
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
