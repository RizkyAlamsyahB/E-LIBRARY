@extends('layouts.app')

@section('main-content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Pegawai</h3>
            {{-- <p class="text-subtitle text-muted">A page where users can change employee information</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    {{-- <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li> --}}
                    <li class="breadcrumb-item active" aria-current="page"><a
                            href="{{ route('employees.index') }}">Pegawai</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-lg-4">
            <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl position-relative">
                                <img id="avatarImage"
                                    src="{{ $employee->photo ? asset('storage/' . $employee->photo) : asset('template/dist/assets/compiled/jpg/user.png') }}"
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
                            <h3 class="mt-3">{{ $employee->name }}</h3>
                            <p class="text-small">{{ $employee->department }}</p>
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

                    <div class="form-group">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $employee->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $employee->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="division_id" class="form-label">{{ __('Divisi') }}</label>
                        <select name="division_id" id="division_id" class="form-control" required>
                            <option value="">{{ __('Pilih Divisi') }}</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ old('division_id', $employee->division_id) == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('division_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="role-user" name="role" value="user"
                                {{ old('role', $employee->role) == 'user' ? 'checked' : '' }}>
                            <label class="form-check-label" for="role-user">User</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="role-admin" name="role" value="admin"
                                {{ old('role', $employee->role) == 'admin' ? 'checked' : '' }}>
                            <label class="form-check-label" for="role-admin">Admin</label>
                        </div>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="marital_status" class="form-label">Status Pernikahan</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="marital_status_single"
                                name="marital_status" value="single"
                                {{ old('marital_status', $employee->marital_status) == 'single' ? 'checked' : '' }}
                                required>
                            <label class="form-check-label" for="marital_status_single">Single</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="marital_status_married"
                                name="marital_status" value="married"
                                {{ old('marital_status', $employee->marital_status) == 'married' ? 'checked' : '' }}
                                required>
                            <label class="form-check-label" for="marital_status_married">Married</label>
                        </div>
                        @error('marital_status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control mb-3 flatpickr-no-config" id="date_of_birth"
                            name="date_of_birth" placeholder="Select date.."
                            value="{{ old('date_of_birth', $employee->date_of_birth) }}">
                        @error('date_of_birth')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Nomor Telfon</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ old('phone', $employee->phone) }}">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" name="address">{{ old('address', $employee->address) }}</textarea>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="gender-male" name="gender"
                                value="male" {{ old('gender', $employee->gender) == 'male' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender-male">Laki-Laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="gender-female" name="gender"
                                value="female" {{ old('gender', $employee->gender) == 'female' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender-female">Perempuan</label>
                        </div>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3 rounded-pill">Submit</button>
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary mt-3 rounded-pill">Back</a>
                </div>
            </div>

        </div>
        </form>
    </div>
    <script>
        // Inisialisasi Flatpickr
        flatpickr("#date_of_birth", {
            dateFormat: "Y-m-d", // Format tanggal sesuai dengan yang Anda inginkan
            // Anda bisa menambahkan konfigurasi lainnya sesuai kebutuhan
        });
    </script>
@endsection
