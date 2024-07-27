@extends('layouts.app')

@section('main-content')
 <div class="page-content" style="display: none;">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Employee</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Employee</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('employees.update', $employee->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('Nama') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $employee->name) }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('Email') }}<span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $employee->email) }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation"
                                    class="form-label">{{ __('Konfirmasi Password') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control">
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">{{ __('Nomor Telepon') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone', $employee->phone) }}">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="date_of_birth" class="form-label">{{ __('Tanggal Lahir') }}<span
                                        class="text-danger">*</span></label>
                                <input type="date" name="date_of_birth" id="date_of_birth"
                                    class="form-control mb-3 flatpickr-no-config" placeholder="Select date.."
                                    value="{{ old('date_of_birth', $employee->date_of_birth) }}">
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
                                        value="male" {{ old('gender', $employee->gender) === 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender-male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="gender-female" name="gender"
                                        value="female"
                                        {{ old('gender', $employee->gender) === 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender-female">Female</label>
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
                                        value="user" {{ old('role', $employee->role) === 'user' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_user">User</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="role_admin" name="role"
                                        value="admin" {{ old('role', $employee->role) === 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_admin">Admin</label>
                                </div>
                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="division">Divisi<span class="text-danger">*</span></label>
                                <select name="division_id" id="division" class="form-control">
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ $employee->division_id === $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="subsections">Subbagian<span class="text-danger">*</span></label>
                                <select name="subsections[]" id="subsections" class="form-control">
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
                let selectedSubsections = @json($employee->subsections->pluck('id') ?? []);

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
                                        .id + '"' +
                                        (selectedSubsections.includes(subsection.id) ?
                                            ' selected' : '') +
                                        '>' + subsection.name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#subsections').empty();
                    }
                });

                // Trigger change event to load subsections for the current division
                $('#division').trigger('change');
            });
        </script>


        <script>
            // Inisialisasi Flatpickr
            flatpickr("#date_of_birth", {
                dateFormat: "Y-m-d", // Format tanggal sesuai dengan yang Anda inginkan
            });
        </script>
    </div>
@endsection
