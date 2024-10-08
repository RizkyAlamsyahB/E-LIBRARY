@extends('layouts.app')
@section('title', 'Tambah Di Bawah Kekuasaan')
@section('main-content')
    <div class="page-content" style="display: none;">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                {{-- <p class="text-subtitle text-muted">A page where users can add person in charge information</p> --}}
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('person_in_charge.index') }}">Di Bawah Kekuasaan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Di Bawah Kekuasaan</li>
                    </ol>
                </nav>
            </div>
        </section>
        <h3>Tambah Di Bawah Kekuasaan</h3>
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('person_in_charge.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Di Bawah Kekuasaan<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-pill mt-3">Simpan</button>
                            <a href="{{ route('person_in_charge.index') }}"
                                class="btn btn-secondary mt-3 rounded-pill">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
