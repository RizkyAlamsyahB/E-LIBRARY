@extends('layouts.app')

@section('main-content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                {{-- <p class="text-subtitle text-muted">A page where users can add person in charge information</p> --}}
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('divisions.index') }}">Divisi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Divisi</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="row position-relative">
            <div class="col-12">
                <h3>Tambah Divisi</h3>
                <div class="card">
                    <div class="card-body">
                        @if ($subsections->isEmpty())
                            <div class="alert alert-warning">
                                Belum ada Subbagian. Silakan <a href="{{ route('subsections.create') }}">buat Subbagian</a>
                                terlebih dahulu.
                            </div>
                        @else
                            <form action="{{ route('divisions.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nama Divisi<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="subsections">Subbagian<span class="text-danger">*</span></label>
                                    <select name="subsections[]" id="subsections" class="form-control custom-select"
                                        required>
                                        @foreach ($subsections as $subsection)
                                            <option value="{{ $subsection->id }}">{{ $subsection->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <style>
                                    .custom-select {
                                        max-height: 150px;
                                        /* Sesuaikan tinggi maksimum sesuai kebutuhan */
                                        overflow-y: auto;
                                    }
                                </style>


                                <button type="submit" class="btn btn-primary mt-3 rounded-pill">Simpan</button>
                                <a href="{{ route('divisions.index') }}"
                                    class="btn btn-secondary mt-3 rounded-pill">Batal</a>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('#subsections').select2({
                placeholder: "Pilih Subbagian",
                allowClear: true
            });
        });
    </script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

@endsection
