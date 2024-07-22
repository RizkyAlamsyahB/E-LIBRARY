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
                        {{-- <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('divisions.index') }}">Divisi</a></li>
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
                        <form action="{{ route('divisions.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Divisi<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 rounded-pill">Simpan</button>
                            <a href="{{ route('divisions.index') }}" class="btn btn-secondary mt-3 rounded-pill">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
