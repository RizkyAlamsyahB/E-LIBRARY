@extends('layouts.app')

@section('title', 'Dokumen')

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
                                    <th>Nomor Surat</th>
                                    <th>Status</th>
                                    <th>Di Unggah Oleh</th>
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

            <!-- View Details Modal -->
            <div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog"
                aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title text-white" id="viewDetailsModalLabel">Detail Dokumen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="documentDetailsContent">
                            <!-- Document details will be loaded here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
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

                    // Initialize DataTable
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
                                data: 'combinedInfo',
                                name: 'combinedInfo'
                            },
                            {
                                data: 'documentStatus',
                                name: 'documentStatus'
                            },
                            {
                                data: 'uploaderName',
                                name: 'uploaderName'
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



                    // Hide alert after 2 seconds
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

                    // Handle view details button click
                    $('#documentTable').on('click', '.btn-view-details', function() {
                        var id = $(this).data('id');
                        var url = '{{ route('documents.show', ':id') }}'.replace(':id', id);

                        $.get(url, function(data) {
                            $('#documentDetailsContent').html(`
                <div class="document-details">
                    <p><span class="label">Nomor Surat:</span> <span class="value">${data.number} / ${data.classification} / ${data.personInCharge} / ${data.documentCreationDate}</span></p>
                    <p><span class="label">Judul:</span> <span class="value">${data.title}</span></p>
                    <p><span class="label">Description:</span> <span class="value">${data.description}</span></p>
                    <p><span class="label">Sifat:</span> <span class="value">${data.status}</span></p>
                    <p><span class="label">Di Unggah Pada:</span> <span class="value">${data.createdAt}</span></p>
                    <p><span class="label">Di Upload Oleh:</span> <span class="value">${data.uploader}</span></p>
                    <p><span class="label">Divisi:</span> <span class="value">${data.division}</span></p>
                    <p><span class="label">Sub Bagian:</span> <span class="value">${data.subsection}</span></p>
                </div>
            `);
                            $('#viewDetailsModal').modal('show');
                        });
                    });
                });
            </script>
            <style>
                .document-details {
                    line-height: 1.6;
                }

                .document-details p {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 0.5rem;
                    /* Adjust spacing between lines if needed */
                }

                .document-details span.label {
                    flex: 1;
                    text-align: right;
                    /* Aligns the label to the right */
                    margin-right: 1rem;
                    /* Adjust spacing between label and value */
                    font-weight: bold;
                }

                .document-details span.value {
                    flex: 2;
                }
            </style>


        </section>
    </div>
@endsection
