@extends('layouts.app')

@section('main-content')
    <div class="page-content" style="display: none;">
        <section class="row position-relative">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Kode Klasifikasi</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('classification-codes.index') }}">Kode
                                    Klasifikasi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('classification-codes.update', $classificationCode->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama Kode Klasifikasi<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $classificationCode->name }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill">Simpan</button>
                        <a href="{{ route('classification-codes.index') }}"
                            class="btn btn-outline-secondary rounded-pill">Batal</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
