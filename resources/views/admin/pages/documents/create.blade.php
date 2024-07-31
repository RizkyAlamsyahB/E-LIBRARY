@extends('layouts.app')
@section('title', 'Tambah Dokumen')
@section('main-content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="page-content" style="display: none;">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Dokumen</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Dokumen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Dokumen</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="row position-relative">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif


                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="document-upload-form" action="{{ route('documents.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="classification_code_id">Kode Klasifikasi <span
                                        class="text-danger">*</span></label>
                                <select name="classification_code_id" id="classification_code_id" class="form-control"
                                    required>
                                    <option value="">Pilih Kode Klasifikasi</option>
                                    @foreach ($classificationCodes as $code)
                                        <option value="{{ $code->id }}">{{ $code->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Pilih kode klasifikasi yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="person_in_charge_id">Penanggung Jawab <span class="text-danger">*</span></label>
                                <select name="person_in_charge_id" id="person_in_charge_id" class="form-control" required>
                                    <option value="">Tidak Ada</option>
                                    @foreach ($personsInCharge as $person)
                                        <option value="{{ $person->id }}">{{ $person->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Pilih penanggung jawab dokumen yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="number">Nomor Dokumen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="number" name="number" required>
                                <small class="text-muted">Masukkan nomor dokumen yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="title">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required>
                                <small class="text-muted">Masukkan judul dokumen yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                <small class="text-muted">Masukkan deskripsi dokumen yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="document_creation_date">Tanggal dan Tahun Pembuatan Dokumen <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control mb-3" id="document_creation_date"
                                    name="document_creation_date" required placeholder="Pilih tanggal">
                                <small class="text-muted">Pilih tanggal pembuatan dokumen yang sesuai.</small>
                            </div>

                            <div class="form-group">
                                <label for="document_status_id">Status <span class="text-danger">*</span></label>
                                <div>
                                    @foreach ($documentStatuses as $status)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="document_status_id"
                                                required id="status_{{ $status->id }}" value="{{ $status->id }}"
                                                {{ $loop->first ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="status_{{ $status->id }}">{{ $status->status }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted">Pilih status dokumen yang sesuai.</small>
                            </div>

                            <div class="form-group">
                                <label for="file">File <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="file" name="file" required>
                                <small class="text-muted">Unggah file dokumen yang sesuai. Maksimal ukuran file adalah
                                    10GB.</small>
                                <div class="progress mt-2">
                                    <div id="progress-bar" class="progress-bar progress-bar-striped" role="progressbar"
                                        style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 rounded-pill">Simpan</button>
                            <a href="{{ route('documents.index') }}"
                                class="btn btn-secondary mt-3 rounded-pill">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {


            $('#document-upload-form').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                let formData = new FormData(this); // Gather form data
                let xhr = new XMLHttpRequest(); // Create XMLHttpRequest instance

                xhr.open('POST', '{{ route('documents.store') }}',
                    true); // Open POST connection to the specified route
                xhr.setRequestHeader('X-CSRF-TOKEN',
                    '{{ csrf_token() }}'); // Set CSRF token header for security

                // Handle progress event to update the progress bar
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        let percentComplete = (e.loaded / e.total) * 100;
                        let progressBar = document.getElementById('progress-bar');
                        progressBar.style.width = percentComplete +
                            '%'; // Update progress bar width
                        progressBar.setAttribute('aria-valuenow',
                            percentComplete); // Update aria value
                        progressBar.innerHTML = Math.round(percentComplete) +
                            '%'; // Show percentage on progress bar
                    }
                });

                // Handle upload completion
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Dokumen Berhasil Ditambahkan.',
                            timer: 2000,
                            timerProgressBar: true,
                            willClose: () => {
                                window.location.href =
                                '{{ route('documents.index') }}'; // Redirect to index page after a short delay
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Upload failed: ' + xhr.responseText
                        });
                    }
                };


                xhr.send(formData); // Send form data
            });
        });
    </script>

    <script>
        flatpickr("#document_creation_date", {
            dateFormat: "d-m-Y",
        });
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection
