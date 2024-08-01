@extends('layouts.app')
@section('title', 'Profil')
@section('main-content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <div class="page-content" style="display: none;">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Profil Akun</h3>
                <p class="text-subtitle text-muted">Halaman di mana pengguna dapat melihat informasi profil mereka</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profil</li>
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
                                <h3 class="mt-3 text-center">{{ Auth::user()->name }}</h3>
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
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Tutup"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Kesalahan:</strong> Silakan periksa kolom input Anda di bawah ini.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Tutup"></button>
                                </div>
                            @endif

                            <!-- Fields yang dapat diubah -->
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('Nama') }}</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    value="{{ $user->name }}" placeholder="Masukkan nama lengkap Anda"
                                    title="Masukkan nama lengkap sesuai identitas" required>
                            </div>


                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="{{ $user->email }}" placeholder="Masukkan email Anda"
                                    title="Masukkan email yang valid dan aktif" required>
                            </div>


                            <div class="form-group">
                                <label for="phone" class="form-label">Telepon</label>
                                <input type="tel" id="phone" name="phone" class="form-control"
                                    value="{{ old('phone', $user->phone) }}" pattern="[0-9]{12,13}"
                                    placeholder="Masukkan nomor telepon 12 atau 13 digit"
                                    title="Nomor telepon harus terdiri dari 12 atau 13 digit angka" required>
                            </div>

                            <div class="form-group">
                                <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control"
                                    value="{{ $user->date_of_birth }}" placeholder="Pilih tanggal lahir"
                                    title="Pilih tanggal lahir Anda" required>
                            </div>


                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input type="radio" id="gender_male" name="gender" value="male"
                                            class="form-check-input" {{ $user->gender == 'male' ? 'checked' : '' }}>
                                        <label for="gender_male" class="form-check-label">Laki-Laki</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input type="radio" id="gender_female" name="gender" value="female"
                                            class="form-check-input" {{ $user->gender == 'female' ? 'checked' : '' }}>
                                        <label for="gender_female" class="form-check-label">Perempuan</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Fields yang read-only -->
                            <div class="form-group">
                                <label for="division" class="form-label">Divisi</label>
                                <input type="text" id="division" class="form-control"
                                    value="{{ $user->division ? $user->division->name : 'Belum ada divisi' }}" readonly
                                    disabled>
                            </div>

                            <div class="form-group">
                                <label for="subsections" class="form-label">Subbagian</label>
                                <ul class="list-unstyled">
                                    @forelse ($user->subsections as $subsection)
                                        <li>{{ $subsection->name }}</li>
                                    @empty
                                        <li>Belum ada subbagian yang ditugaskan</li>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="form-group">
                                <button type="submit"
                                    class="btn btn-primary rounded-pill">{{ __('Simpan Perubahan') }}</button>
                            </div>
                        </form>

                        <!-- Form Update Password -->
                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="update_password_current_password"
                                    class="form-label">{{ __('Password Lama') }}</label>
                                <input type="password" name="current_password" id="update_password_current_password"
                                    class="form-control" autocomplete="current-password" required>
                                @error('current_password')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="update_password_password"
                                    class="form-label">{{ __('Password Baru') }}</label>
                                <input type="password" name="password" id="update_password_password"
                                    class="form-control" autocomplete="new-password" required>
                                @error('password')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="update_password_password_confirmation"
                                    class="form-label">{{ __('Konfirmasi Password') }}</label>
                                <input type="password" name="password_confirmation"
                                    id="update_password_password_confirmation" class="form-control"
                                    autocomplete="new-password" required>
                                @error('password_confirmation')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit"
                                    class="btn btn-primary rounded-pill">{{ __('Simpan Perubahan') }}</button>
                            </div>
                        </form>

                        @if (session('status') === 'password-updated')
                            <p class="mt-2 text-sm text-gray-600">{{ __('Password berhasil diperbarui.') }}</p>
                        @endif

                        <!-- Form Delete Account -->
                        <form method="post" action="{{ route('profile.destroy') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('delete')

                            <div class="form-group">
                                <h2 class="text-lg font-medium text-gray-900">{{ __('Hapus Akun') }}</h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __('Setelah akun Anda dihapus, semua sumber daya dan data terkait akan dihapus secara permanen. Harap masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
                                </p>

                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control" required
                                    placeholder="{{ __('Password') }}">
                                @error('password')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-3 rounded-pill"
                                    onclick="event.preventDefault(); document.getElementById('delete-account-modal').classList.add('hidden');">{{ __('Batal') }}</button>
                                <button type="submit"
                                    class="btn btn-danger rounded-pill">{{ __('Hapus Akun') }}</button>
                            </div>
                        </form>

                    </div>
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

        // Menambahkan efek fade out pada alert setelah 2 detik
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('hidden');
                }, 2000); // 2 detik
            });
        });
    </script>
@endsection
