@extends('layouts.app')
@section('title', 'Tambah Sifat Dokumen')
@section('main-content')
    <div class="page-content" style="display: none;">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Sifat Dokumen</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('document_status.index') }}">Sifat Dokumen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Sifat Dokumen</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="row position-relative">
            <div class="card">

                <div class="card-body">
                    <form action="{{ route('document_status.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="status">Nama Sifat Dokumen<span class="text-danger">*</span></label>
                            <input type="text" name="status" id="status" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 rounded-pill">Simpan</button>
                        <a href="{{ route('document_status.index') }}" class="btn btn-secondary mt-3 rounded-pill">Batal</a>
                    </form>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
