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
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
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
                        <table class="table table-striped" id="document-status-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sifat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables akan mengisi bagian ini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal konfirmasi hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus sifat dokumen ini?
                </div>
                <div class="modal-footer">
                    <form id="delete-form" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sertakan file JavaScript -->
    <script src="{{ asset('template/dist/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('template/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

    <script>
        $(document).ready(function() {
            var table = $('#document-status-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('document_status.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']],
                paging: true,
                searching: true,
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

            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 2000);

            $('[data-toggle="tooltip"]').tooltip();

            // Menangani klik tombol hapus
            $('#document-status-table').on('click', '.dropdown-item[data-bs-target="#deleteModal"]', function() {
                var id = $(this).data('id');
                var form = $('#delete-form');
                var action = '{{ route('document_status.destroy', ':id') }}';
                action = action.replace(':id', id);
                form.attr('action', action);
            });
        });
    </script>
@endsection
