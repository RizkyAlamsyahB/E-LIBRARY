@extends('layouts.app')
@section('title', 'Dashboard')
@section('main-content')
    <div class="page-content">
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

                    <!-- Total Document  -->
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
                                        <h6 class="text-muted font-semibold">Total Dokumen</h6>
                                        <h6 class="font-extrabold mb-0">{{ $documentCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <!-- Total Divisions -->
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon blue mb-2">
                                                <i class="bi bi-briefcase bold mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Divisi</h6>
                                            <h6 class="font-extrabold mb-0">{{ $divisionCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                            <h6 class="text-muted font-semibold">Total PIC</h6>
                                            <h6 class="font-extrabold mb-0">{{ $picCount }}</h6>
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
                                            <h6 class="text-muted font-semibold">Total Status Dokumen</h6>
                                            <h6 class="font-extrabold mb-0">{{ $documentStatusCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    <!-- Example Card for Attendance (Static Data) -->
                    {{-- <div class="col-12 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="bi bi-database bold mb-4 me-2"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Hadir</h6>
                                        <h6 class="font-extrabold mb-0">183.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Example Card for Absence (Static Data) -->
                    {{-- <div class="col-12 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi bi-person bold mb-4 me-3"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Alfa</h6>
                                        <h6 class="font-extrabold mb-0">80.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

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
