@extends('layouts.app')
@section('title', 'Tambah Status Dokumen')
@section('main-content')
  <div class="page-content" style="display: none;">
        <section class="row position-relative">
            <div class="col-12">
                <h3>Tambah Status Dokumen</h3>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('document_status.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="status">Status Dokumen<span class="text-danger">*</span></label>
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
