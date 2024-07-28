@extends('layouts.app')

@section('main-content')
    <div class="page-content" style="display: none;">
        <section class="row position-relative">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Dokumen</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dokumen</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

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
                        <a href="{{ route('documents.create') }}" class="btn btn-primary mb-3 rounded-pill">+ Tambah</a>
                        <table class="table" id="documentTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>No Dokumen</th>
                                    <th>Kode Klasifikasi</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Tanggal Pembuatan Dokumen</th>
                                    <th>Di Unggah Oleh</th>
                                    <th>Divisi</th>
                                    <th>Subbagian</th>
                                    <th>Di Unggah Pada</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables will populate this -->
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
                            Apakah Anda yakin ingin menghapus <strong id="deleteDocumentTitle"></strong>?
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


            <script>
                $(document).ready(function() {
                    // Fungsi untuk mengubah format tanggal
                    function formatDate(dateStr) {
                        const date = new Date(dateStr);
                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = date.getFullYear();
                        return `${day}-${month}-${year}`;
                    }

                    $('#documentTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route('documents.index') }}',
                            type: 'GET'
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'title',
                                name: 'title'
                            },
                            {
                                data: 'number',
                                name: 'number'
                            },
                            {
                                data: 'classificationCodeName',
                                name: 'classificationCodeName'
                            },
                            {
                                data: 'personInChargeName',
                                name: 'personInChargeName'
                            },
                            {
                                data: 'document_creation_date',
                                name: 'document_creation_date',
                                render: function(data, type, row) {
                                    return formatDate(data);
                                }
                            },
                            {
                                data: 'uploaderName',
                                name: 'uploaderName'
                            },
                            {
                                data: 'userDivisionName',
                                name: 'userDivisionName'
                            },
                            {
                                data: 'subsectionName',
                                name: 'subsectionName'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                render: function(data, type, row) {
                                    return formatDate(data);
                                }
                            },
                            {
                                data: 'documentStatus',
                                name: 'documentStatus'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        order: [
                            [0, 'asc']
                        ],
                        paging: true,
                        ordering: true,
                        info: true,
                        responsive: true,
                        lengthMenu: [10, 25, 50, 100],
                        dom: '<"d-flex justify-content-between"<"d-flex"l><"mt-4"f>>rt<"d-flex justify-content-between"<"d-flex"i><"ml-auto"p>> ',
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search..."
                        }
                    });

                    // Hide the success alert after 2 seconds
                    setTimeout(function() {
                        $('.alert').fadeOut('slow');
                    }, 2000);

                    // Initialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Handle delete button click
                    $('#documentTable').on('click', '.btn-delete', function() {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endsection
