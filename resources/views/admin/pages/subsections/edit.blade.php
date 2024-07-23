@extends('layouts.app')

@section('main-content')
    <div class="page-content">
        <section class="row position-relative">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Subbagian</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li> --}}
                            <li class="breadcrumb-item"><a href="{{ route('subsections.index') }}">Subbagian</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('subsections.update', $subsection->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $subsection->name }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill">{{ __('Submit') }}</button>
                        <a href="{{ route('subsections.index') }}" class="btn btn-outline-secondary  rounded-pill">Batal</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
