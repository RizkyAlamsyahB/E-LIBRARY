@extends('layouts.app')
@section('title', 'Dashboard')
@section('main-content')

    <div class="page-content" style="display: none;">
        @if (request()->has('verified'))
            <div class="alert alert-success alert-dismissible fade show position-fixed rounded-pill"
                style="bottom: 1rem; right: 1rem; z-index: 1050; max-width: 90%; width: auto;" role="alert">
                {{ __('Email Anda berhasil diverifikasi!') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <section class="row">
            <div class="col-12">
                <div class="row">
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <!-- Total Users -->
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple mb-2">
                                                <i class="bi bi-people bold mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Pegawai</h6>
                                            <h6 class="font-extrabold mb-0">{{ $userCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Total Document -->
                    <div class="col-12 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="bi bi-file-earmark-fill bold mb-4 me-2"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Seluruh Dokumen</h6>
                                        <h6 class="font-extrabold mb-0">{{ $documentCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <!-- Total Person In Charge (PIC) -->
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon green mb-2">
                                                <i class="bi bi-person-badge bold mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Di Bawah Kekuasaan</h6>
                                            <h6 class="font-extrabold mb-0">{{ $picCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Total Classification Codes -->
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple mb-2">
                                                <i class="bi bi-tag bold mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Kode Klasifikasi</h6>
                                            <h6 class="font-extrabold mb-0">{{ $classificationCodeCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Document Status -->
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon red mb-2">
                                                <i class="bi bi-file-text bold mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Sifat Dokumen</h6>
                                            <h6 class="font-extrabold mb-0">{{ $documentStatusCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Subsections -->
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon green mb-2">
                                                <i class="bi bi-list-check bold mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Sub Bagian</h6>
                                            <h6 class="font-extrabold mb-0">{{ $subsectionCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Jabatan -->
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple mb-2">
                                                <i class="bi bi-briefcase bold mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Jabatan</h6>
                                            <h6 class="font-extrabold mb-0">{{ $divisionCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Documents Uploaded by Current User -->
                    <div class="col-12 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="bi bi-file-earmark-text bold mb-4 me-2"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Dokumen yang Saya Upload</h6>
                                        <h6 class="font-extrabold mb-0">{{ $uploadedDocumentsCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Total Document per Sub Bagian -->
                    <div class="col-12">
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="stats-icon purple me-3">
                                                    <i class="bi bi-file-text bold mb-4 me-2"></i>
                                                </div>
                                                <h6 class="text-muted font-semibold mb-0">Total Dokumen per Sub Bagian</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap">
                                    @foreach ($subsectionsWithDocumentCount as $subsection)
                                        <div class="card me-3 mb-3" style="flex: 1 1 200px;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $subsection->name }}</h5>
                                                <p class="card-text">Total Dokumen: {{ $subsection->documents_count }}</p>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Card for documents without subsections -->
                                    <div class="card me-3 mb-3" style="flex: 1 1 200px;">
                                        <div class="card-body">
                                            <h5 class="card-title">Tidak Terasosiasi</h5>
                                            <p class="card-text">Total Dokumen: {{ $documentsWithoutSubsectionCount }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Documents Widget -->
        <div class="docs-widget" style="position: fixed; bottom: 30px; right: 20px; z-index: 1000;">
            <a href="{{ route('documents.create') }}" class="zoom-effect">
                <img src="{{ asset('template/dist/assets/compiled/png/docs.png') }}" alt="Dokumen"
                    style="width: 50px; height: auto;">
            </a>
        </div>

        <style>
            .zoom-effect {
                display: inline-block;
                transition: transform 0.3s ease;
            }

            .zoom-effect:hover {
                transform: scale(1.2);
                /* Sesuaikan nilai ini untuk tingkat zoom yang diinginkan */
            }
        </style>
    </div>
@endsection
