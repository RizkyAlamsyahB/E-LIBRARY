@extends('layouts.app')
@section('title', 'Edit Dokumen')
@section('main-content')
    <div class="page-content" style="display: none;">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Dokumen</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Dokumen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Dokumen</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="row position-relative">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-content">
                            @if (session('warning'))
                                <div class="alert alert-warning">
                                    {{ session('warning') }}
                                </div>
                            @endif
                        </div>
                        <form id="edit-document-form" action="{{ route('documents.update', $document->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="classification_code_id">Kode Klasifikasi <span
                                        class="text-danger">*</span></label>
                                <select name="classification_code_id" id="classification_code_id" class="form-control"
                                    required>
                                    <option value="">Pilih Kode Klasifikasi</option>
                                    @foreach ($classificationCodes as $code)
                                        <option value="{{ $code->id }}"
                                            {{ $document->classification_code_id == $code->id ? 'selected' : '' }}>
                                            {{ $code->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Pilih kode klasifikasi yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="person_in_charge_id">Penanggung Jawab <span class="text-danger">*</span></label>
                                <select name="person_in_charge_id" id="person_in_charge_id" class="form-control" required>
                                    <option value="">Tidak Ada</option>
                                    @foreach ($personsInCharge as $person)
                                        <option value="{{ $person->id }}"
                                            {{ $document->person_in_charge_id == $person->id ? 'selected' : '' }}>
                                            {{ $person->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Pilih penanggung jawab dokumen yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="number">Nomor Dokumen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="number" name="number"
                                    value="{{ $document->number }}" required>
                                <small class="text-muted">Masukkan nomor dokumen yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="title">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $document->title }}" required>
                                <small class="text-muted">Masukkan judul dokumen yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $document->description }}</textarea>
                                <small class="text-muted">Masukkan deskripsi dokumen yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="document_creation_date">Tanggal dan Tahun Pembuatan Dokumen <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control mb-3 flatpickr-no-config"
                                    id="document_creation_date" name="document_creation_date"
                                    value="{{ \Carbon\Carbon::parse($document->document_creation_date)->format('Y-m-d') }}"
                                    required placeholder="Pilih tanggal">
                                <small class="text-muted">Pilih tanggal pembuatan dokumen yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="document_status_id">Status <span class="text-danger">*</span></label>
                                <div>
                                    @foreach ($documentStatuses as $status)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="document_status_id"
                                                required id="status_{{ $status->id }}" value="{{ $status->id }}"
                                                {{ $document->document_status_id == $status->id ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="status_{{ $status->id }}">{{ $status->status }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted">Pilih status dokumen yang sesuai.</small>
                            </div>
                            <div class="form-group">
                                <label for="file">File</label>
                                <input type="file" class="form-control" id="file" name="file">
                                <small class="text-muted">Unggah file dokumen yang sesuai. Maksimal ukuran file adalah
                                    10GB.</small>
                                <a href="{{ route('documents.download', basename($document->file_path)) }}"
                                    class="btn btn-link">Download File Saat Ini</a>
                            </div>
                            <div class="progress mt-2">
                                <div id="progress-bar" class="progress-bar progress-bar-striped" role="progressbar"
                                    style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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
        document.getElementById('edit-document-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah pengiriman form default

            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();

            xhr.open('POST', this.action, true);
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    let percentComplete = (e.loaded / e.total) * 100;
                    let progressBar = document.getElementById('progress-bar');
                    progressBar.style.width = percentComplete + '%'; // Memperbarui lebar progress bar
                    progressBar.setAttribute('aria-valuenow', percentComplete); // Memperbarui nilai aria
                    if (percentComplete < 100) {
                        progressBar.innerHTML = Math.round(percentComplete) +
                            '%'; // Tampilkan persentase di progress bar
                    } else {
                        progressBar.innerHTML =
                            'Loading...'; // Ganti teks menjadi "Loading..." saat mencapai 100%
                    }
                }
            });

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Redirect or handle successful upload
                    window.location.href = "{{ route('documents.index') }}";
                } else {
                    // Handle error
                    alert('Terjadi kesalahan saat mengunggah dokumen.');
                }
            };

            xhr.send(formData);
        });
    </script>

    <script>
        // Inisialisasi Flatpickr
        flatpickr("#document_creation_date", {
            dateFormat: "Y-m-d", // Format tanggal sesuai dengan yang Anda inginkan
        });
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection
