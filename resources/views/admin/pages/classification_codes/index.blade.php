@extends('layouts.app')

@section('main-content')
    <div class="page-content">
        <section class="row position-relative">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Kode Klasifikasi</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kode Klasifikasi</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show position-fixed rounded-pill"
                    style="bottom: 1rem; right: 1rem; z-index: 1050; max-width: 90%; width: auto;" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Button to add a new classification code -->
                        <a href="{{ route('classification-codes.create') }}" class="btn btn-primary mb-3 rounded-pill">+ Tambah</a>
                        <table class="table table-striped" id="classificationCodeTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables will populate this section -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Include JavaScript files -->
    <script src="{{ asset('template/dist/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/static/js/pages/datatables.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#classificationCodeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('classification-codes.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                lengthMenu: [10, 25, 50, 100],
                dom: '<"d-flex justify-content-between"<"d-flex"l><"mt-4"f>>rt<"d-flex justify-content-between"<"d-flex"i><"ml-auto"p>> ',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari..."
                }
            });

            // Hide the success alert after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
