@extends('layouts.app')
@section('title', 'Tambah Pegawai')
@section('main-content')
    <div class="page-content" style="display: none;">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Pegawai</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li> --}}
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Pegawai</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Pegawai</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('Nama') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('Email') }}<span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">{{ __('Password') }}<span
                                        class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">{{ __('Konfirmasi Password') }}<span
                                        class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" required>
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="phone" class="form-label">{{ __('Nomor Telfon') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone') }}"required   inputmode="numeric" pattern="[0-9]*"  placeholder="087xxxxxxxxx">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="date_of_birth" class="form-label">{{ __('Tanggal Lahir') }}<span
                                        class="text-danger">*</span></label>
                                <input type="date" name="date_of_birth" id="date_of_birth"
                                    class="form-control mb-3 flatpickr-no-config" placeholder="Select date.."
                                    value="{{ old('date_of_birth') }}"required>
                                @error('date_of_birth')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="form-group">
                                <label for="gender" class="form-label">{{ __('Jenis Kelamin') }}<span
                                        class="text-danger">*</span></label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="gender-male" name="gender"
                                        value="male" {{ old('gender') === 'male' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="gender-male">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="gender-female" name="gender"
                                        value="female" {{ old('gender') === 'female' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="gender-female">Perempuan</label>
                                </div>

                                @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role" class="form-label">{{ __('Role') }}<span
                                        class="text-danger">*</span></label>
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
                            <div class="form-group">
                                <label for="division">Jabatan<span class="text-danger">*</span></label>
                                <select name="division_id" id="division" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jabatan</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="subsections">Subbagian<span class="text-danger">*</span></label>
                                <select name="subsections[]" id="subsections" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jabatan Terlebih Dahulu</option>
                                    <!-- Options will be filled by JavaScript -->
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 rounded-pill">Simpan</button>
                            <a href="{{ route('employees.index') }}"
                                class="btn btn-secondary mt-3 rounded-pill">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <script src="{{ asset('template/dist/assets/extensions/jquery/jquery.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#division').change(function() {
                    let divisionId = $(this).val();
                    if (divisionId) {
                        $.ajax({
                            url: '{{ route('subsections.getByDivision') }}',
                            type: 'GET',
                            data: {
                                division_id: divisionId
                            },
                            success: function(data) {
                                $('#subsections').empty();
                                $.each(data, function(key, subsection) {
                                    $('#subsections').append('<option value="' + subsection
                                        .id + '">' + subsection.name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#subsections').empty();
                    }
                });
            });
        </script>
        <script>
            // Inisialisasi Flatpickr
            flatpickr("#date_of_birth", {
                dateFormat: "Y-m-d", // Format tanggal sesuai dengan yang Anda inginkan
                // Anda bisa menambahkan konfigurasi lainnya sesuai kebutuhan
            });
        </script>
    </div>
@endsection
