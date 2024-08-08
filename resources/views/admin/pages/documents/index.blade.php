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

            <div class="card col-lg-12">
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{ route('documents.create') }}" class="btn btn-primary mb-3 rounded-pill">+ Tambah</a>
                        <table class="table table-striped" id="documentTable">
                            <!-- Filter Section -->
                            <div class="row">
                                <h5>Filter</h5>
                                <div class="col-md-3 mb-4">
                                    <h6>Sifat Dokumen :</h6>
                                    <div class="form-group">
                                        <select id="filterStatus" class="choices form-select" multiple="multiple">
                                            <option value="">Semua Sifat</option>
                                            @foreach ($statuses as $id => $status)
                                                <option value="{{ $id }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <h6>Uploaders : </h6>
                                    <div class="form-group">
                                        <select id="filterUploader" class="choices form-select" multiple="multiple">
                                            <option value="" disabled>Semua Uploaders</option>
                                            @foreach ($uploaders as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <h6>Person In Charge :</h6>
                                    <div class="form-group">
                                        <select id="filterPersonInCharge" class="choices form-select " multiple="multiple">
                                            <option value="">Semua PIC</option>
                                            @foreach ($personsInCharge as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-4">
                                    <h6>Kode Klasifikasi :</h6>
                                    <div class="form-group">
                                        <select id="filterClassificationCode" class="choices form-select"
                                            multiple="multiple">
                                            <option value="">Semua Kode</option>
                                            @foreach ($classificationCodes as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-4">
                                    <h6>Range Tanggal Dokumen :</h6>
                                    <div class="form-group">
                                        <label for="filterStartDate">Dari:</label>
                                        <input type="date" id="filterDate" class="form-control flatpickr-no-config"
                                            placeholder="Pilih Tanggal...">
                                    </div>
                                    <div class="form-group">
                                        <label for="filterEndDate">Sampai:</label>
                                        <input type="date" id="filterDate" class="form-control flatpickr-no-config"
                                            placeholder="PIlih Tanggal...">
                                    </div>
                                </div>
                            </div>

                    </div>


                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th class="nowrap-column">Nomor Surat</th>
                            <th>Sifat</th>
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
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
    <link rel="stylesheet"
        href="{{ asset('template/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">


    <script>
        $(document).ready(function() {
            // Initialize Choices.js for select elements
            var filterStatus = new Choices('#filterStatus', {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Select Status'
            });

            var filterUploader = new Choices('#filterUploader', {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Select Uploaders'
            });

            var filterPersonInCharge = new Choices('#filterPersonInCharge', {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Select PIC'
            });

            var filterClassificationCode = new Choices('#filterClassificationCode', {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Select Classification Code'
            });

            // Initialize DataTable
            var table = $('#documentTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('documents.index') }}',
                    type: 'GET',
                    data: function(d) {
                        // Add filter parameters to the AJAX request
                        d.status = $('#filterStatus').val();
                        d.uploader = $('#filterUploader').val();
                        d.person_in_charge = $('#filterPersonInCharge').val();
                        d.classification_code = $('#filterClassificationCode').val();
                        d.start_date = $('#filterStartDate').val();
                        d.end_date = $('#filterEndDate').val();
                    }
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
                        name: 'combinedInfo',
                        className: 'nowrap-column'
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

            // Redraw the table on filter change
            $('#filterStatus, #filterUploader, #filterPersonInCharge, #filterClassificationCode, #filterStartDate, #filterEndDate')
                .change(function() {
                    table.ajax.reload();
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
        }

        .document-details span.label {
            flex: 1;
            text-align: right;
            margin-right: 1rem;
            font-weight: bold;
        }

        .document-details span.value {
            flex: 2;
        }

        .nowrap-column {
            white-space: nowrap;
            min-width: 200px;
        }
    </style>
    </section>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script>
        // Initialize Flatpickr
        flatpickr("#filterDate", {
            dateFormat: "Y-m-d", // Date format
        });
    </script>

@endsection
