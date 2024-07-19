@extends('layouts.app')
@section('title', 'Edit PIC')
@section('main-content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Penanggung Jawab</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('person_in_charge.index') }}">Penanggung Jawab</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('person_in_charge.update', $personInCharge->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $personInCharge->name) }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 rounded-pill">Submit</button>
                            <a href="{{ route('person_in_charge.index') }}"
                                class="btn btn-secondary mt-3 rounded-pill">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
