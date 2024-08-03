@extends('layouts.app')

@section('title', 'Sifat Dokumen')

@section('main-content')

    <div class="page-content" style="display: none;">
        <section class="row position-relative">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Sifat Dokumen</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sifat Dokumen</li>
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
                        <a href="{{ route('document_status.create') }}" class="btn btn-primary mb-3 rounded-pill">+
                            Tambah </a>
                        <table class="table table-striped" id="documentStatusTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sifat</th>
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

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title text-white" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus data <strong id="deleteDocumentTitle"></strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form id="deleteForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JS Dependencies -->
            <script src="{{ asset('template/dist/assets/extensions/jquery/jquery.min.js') }}"></script>
            <script src="{{ asset('template/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('template/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}">
            </script>
            <script src="{{ asset('template/dist/assets/static/js/pages/datatables.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert@2"></script>
            <link rel="stylesheet"
                href="{{ asset('template/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">


            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const loadingElement = document.getElementById('loading');
                    const contentElement = document.querySelector('.page-content');

                    loadingElement.style.display = 'none'; // Sembunyikan elemen loading
                    contentElement.style.display = 'block'; // Tampilkan konten
                });

                $(document).ready(function() {
                    $('#documentStatusTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route('document_status.index') }}',
                            type: 'GET'
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false, // Tidak bisa diurutkan
                                searchable: false
                            },
                            {
                                data: 'status',
                                name: 'status',
                                orderable: true // Bisa diurutkan
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        order: [
                            [1, 'asc'] // Mengurutkan berdasarkan kolom 'status' secara default
                        ],
                        paging: true,
                        ordering: true,
                        info: true,
                        responsive: true,
                        lengthMenu: [10, 25, 50, 100],
                        dom: '<<"d-flex"l><f>>rt<"d-flex justify-content-between"<"d-flex"i><"ml-auto"p>> ',
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search..."
                        }
                    });

                    // Hide alert after 2 seconds
                    setTimeout(function() {
                        $('.alert').fadeOut('slow');
                    }, 2000);

                    // Initialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Handle delete button click
                    $('#documentStatusTable').on('click', '.btn-delete', function() {
                        var id = $(this).data('id');
                        var title = $(this).data('title');
                        var url = $(this).data('url');
                        $('#deleteDocumentTitle').text(title);
                        $('#deleteForm').attr('action', url);
                        $('#deleteModal').modal('show');
                    });
                });
            </script>
        </section>
    </div>
@endsection
