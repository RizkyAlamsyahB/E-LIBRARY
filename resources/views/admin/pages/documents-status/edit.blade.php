@extends('layouts.app')
@section('title', 'Edit Sifat Dokumen')
@section('main-content')
    <div class="page-content" style="display: none;">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Sifat Dokumen</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('document_status.index') }}">Sifat Dokumen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Sifat Dokumen</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="row position-relative">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('document_status.update', $documentStatus->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="status" class="form-label">Nama Sifat Dokumen<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="status" name="status"
                                    value="{{ $documentStatus->status }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 rounded-pill">{{ __('Simpan') }}</button>
                            <a href="{{ route('document_status.index') }}"
                                class="btn btn-secondary mt-3 rounded-pill">Batal</a>
                        </form>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
