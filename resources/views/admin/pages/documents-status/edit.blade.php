@extends('layouts.app')

@section('main-content')
    <div class="page-content">
        <section class="row position-relative">
            <div class="col-12">
                <h3>Edit Divisi</h3>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('divisions.update', $division->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nama Divisi</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $division->name }}" required>
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
