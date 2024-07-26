@extends('layouts.app')

@section('main-content')
    <div class="page-content">
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

        @if (!$documentStatuses->count() || !$classificationCodes->count() || !$personsInCharge->count())
            <section class="row">
                <div class="col-12">
                    <div class="alert alert-warning">
                        @if (!$documentStatuses->count())
                            <p>Data status dokumen belum tersedia. Silakan hubungi admin untuk tambahkan status dokumen
                                terlebih dahulu.</p>
                        @endif
                        @if (!$classificationCodes->count())
                            <p>Data kode klasifikasi belum tersedia. Silakan hubungi admin untuk tambahkan kode klasifikasi
                                terlebih dahulu.</p>
                        @endif
                        @if (!$personsInCharge->count())
                            <p>Data penanggung jawab belum tersedia. Silakan hubungi admin untuk tambahkan penanggung jawab
                                terlebih dahulu.</p>
                        @endif
                    </div>
                </div>
            </section>
        @else
            <section class="row position-relative">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
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
                                    <label for="file">File <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                    <small class="text-muted">Unggah file dokumen yang sesuai.</small>
                                    <div class="progress mt-2">
                                        <div id="progress-bar" class="progress-bar progress-bar-striped" role="progressbar"
                                            style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="document_status_id">Status <span class="text-danger">*</span></label>
                                    <div>
                                        @foreach ($documentStatuses as $status)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="document_status_id"
                                                    required id="status_{{ $status->id }}" value="{{ $status->id }}"
                                                    {{ $loop->first ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status_{{ $status->id }}">
                                                    {{ $status->status }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="text-muted">Pilih status dokumen yang sesuai.</small>
                                </div>

                                <div class="form-group">
                                    <label for="document_creation_date">Tanggal dan Tahun Pembuatan Dokumen <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control mb-3 flatpickr-no-config"
                                        id="document_creation_date" name="document_creation_date" required
                                        placeholder="Pilih tanggal">
                                    <small class="text-muted">Pilih tanggal pembuatan dokumen yang sesuai.</small>
                                </div>

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
                                    <label for="person_in_charge_id">Penanggung Jawab <span
                                            class="text-danger">*</span></label>
                                    <select name="person_in_charge_id" id="person_in_charge_id" class="form-control"
                                        required>
                                        <option value="">Tidak Ada</option>
                                        @foreach ($personsInCharge as $person)
                                            <option value="{{ $person->id }}">{{ $person->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Pilih penanggung jawab dokumen yang sesuai.</small>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3 rounded-pill">Simpan</button>
                                <a href="{{ route('documents.index') }}"
                                    class="btn btn-secondary mt-3 rounded-pill">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>

    <script>
        document.getElementById('division_id').addEventListener('change', function() {
            let divisionId = this.value;
            let subsectionSelect = document.getElementById('subsection_id');

            // Clear existing options
            subsectionSelect.innerHTML = '<option value="">Pilih Subbagian</option>';

            if (divisionId) {
                fetch(`/divisions/${divisionId}/subsections`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subsection => {
                            let option = document.createElement('option');
                            option.value = subsection.id;
                            option.text = subsection.name;
                            subsectionSelect.add(option);
                        });
                    });
            }
        });
    </script>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);
            let xhr = new XMLHttpRequest();

            xhr.open('POST', this.action, true);

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    let percentComplete = (e.loaded / e.total) * 100;
                    let progressBar = document.getElementById('progress-bar');
                    progressBar.style.width = percentComplete + '%';
                    progressBar.setAttribute('aria-valuenow', percentComplete);
                }
            });

            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    // Handle success (e.g., show a success message)
                } else {
                    // Handle error (e.g., show an error message)
                }
            });

            xhr.addEventListener('error', function() {
                // Handle error (e.g., show an error message)
            });

            xhr.send(formData);
        });
    </script>

    <script>
        // Inisialisasi Flatpickr
        flatpickr("#document_creation_date", {
            dateFormat: "Y-m-d", // Format tanggal sesuai dengan yang Anda inginkan
            // Anda bisa menambahkan konfigurasi lainnya sesuai kebutuhan
        });
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
   

@endsection
