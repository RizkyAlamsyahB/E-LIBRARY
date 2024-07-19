@extends('layouts.app')
@section('title', 'Edit Status Dokumen')
@section('main-content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('person_in_charge.index') }}">Dokumen Status</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="row position-relative">
            <div class="col-12">
                <h3>Edit Dokumen Status</h3>
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('document_status.update', $documentStatus->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="status" class="form-label">Status Dokumen</label>
                                <input type="text" class="form-control" id="status" name="status"
                                    value="{{ $documentStatus->status }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 rounded-pill">{{ __('Submit') }}</button>
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
