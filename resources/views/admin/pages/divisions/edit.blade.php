@extends('layouts.app')

@section('main-content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Divisi</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('divisions.index') }}">Divisi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Divisi</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="row position-relative">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('divisions.update', $division->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nama Divisi<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $division->name }}" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="subsections">Subbagian<span class="text-danger">*</span></label>
                                <select name="subsections[]" id="subsections" class="form-control custom-select" multiple required>
                                    @foreach($subsections as $subsection)
                                        <option value="{{ $subsection->id }}"
                                            {{ in_array($subsection->id, $selectedSubsections) ? 'selected' : '' }}>
                                            {{ $subsection->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 rounded-pill">Update</button>
                            <a href="{{ route('divisions.index') }}" class="btn btn-secondary mt-3 rounded-pill">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <style>
        .custom-select {
            max-height: 200px; /* Sesuaikan tinggi maksimum sesuai kebutuhan */
            overflow-y: auto;
        }
    </style>
@endsection
