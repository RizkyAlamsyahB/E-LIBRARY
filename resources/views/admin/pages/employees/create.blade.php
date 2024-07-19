@extends('layouts.app')
@section('title', 'Tambah Pegawai')
@section('main-content')
    <div class="page-content">
        <section class="row">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Pegawai</h3>
                    {{-- <p class="text-subtitle text-muted">A page where users can add employee information</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('employees.index') }}">Pegawai</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Pegawai</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('Nama') }}</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation"
                                    class="form-label">{{ __('Konfirmasi Password') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" required>
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="division_id" class="form-label">{{ __('Divisi') }}</label>
                                <select name="division_id" id="division_id" class="form-control" required>
                                    <option value="">{{ __('Pilih Divisi') }}</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">{{ __('Nomor Telfon') }}</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone') }}"required>
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">{{ __('Alamat') }}</label>
                                <textarea type="text" name="address" id="address" class="form-control" value="{{ old('address') }}"required></textarea>
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="date_of_birth" class="form-label">{{ __('Tanggal Lahir') }}</label>
                                <input type="date" name="date_of_birth" id="date_of_birth"
                                    class="form-control mb-3 flatpickr-no-config" placeholder="Select date.."
                                    value="{{ old('date_of_birth') }}"required>
                                @error('date_of_birth')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="gender" class="form-label">{{ __('Jenis Kelamin') }}</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="gender-male" name="gender"
                                        value="male" {{ old('gender') === 'male' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="gender-male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="gender-female" name="gender"
                                        value="female" {{ old('gender') === 'female' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="gender-female">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="gender-other" name="gender"
                                        value="other" {{ old('gender') === 'other' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="gender-other">Other</label>
                                </div>
                                @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="marital_status" class="form-label">{{ __('Status Pernikahan') }}</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="marital_status_single"
                                        name="marital_status" value="single"
                                        {{ old('marital_status') === 'single' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="marital_status_single">Single</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="marital_status_married"
                                        name="marital_status" value="married"
                                        {{ old('marital_status') === 'married' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="marital_status_married">Married</label>
                                </div>
                                @error('marital_status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="role" class="form-label">{{ __('Role') }}</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="role_user" name="role"
                                        value="user" {{ old('role') === 'user' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="role_user">User</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="role_admin" name="role"
                                        value="admin" {{ old('role') === 'admin' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="role_admin">Admin</label>
                                </div>
                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary rounded-pill">{{ __('Submit') }}</button>
                            <a href="{{ route('employees.index') }}"
                                class="btn btn-outline-secondary  rounded-pill">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        // Inisialisasi Flatpickr
        flatpickr("#date_of_birth", {
            dateFormat: "Y-m-d", // Format tanggal sesuai dengan yang Anda inginkan
            // Anda bisa menambahkan konfigurasi lainnya sesuai kebutuhan
        });
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection
