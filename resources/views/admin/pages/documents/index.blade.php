@extends('layouts.app')

@section('main-content')
    <div class="page-content">
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
                <div class="alert alert-danger">
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
                                    <th>Kode Klasifikasi</th>
                                    <th>Di Upload Oleh</th>
                                    <th>Divisi</th>
                                    <th>Subbagian</th>
                                    <th>Tanggal Pembuatan</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $document)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $document->title }}</td>
                                        <td>{{ $document->classificationCode->name ?? 'N/A' }}</td>
                                        <td>{{ $document->uploader->name ?? 'N/A' }}</td>
                                        <td>{{ $userDivision->name ?? 'N/A' }}</td>
                                        <td>{{ $document->subsection->name ?? 'N/A' }}</td>
                                        <td>{{ $document->document_creation_date }}</td>
                                        <td>{{ $document->personInCharge->name ?? 'N/A' }}</td>
                                        <td>{{ $document->documentStatus->status ?? 'N/A' }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('documents.preview', basename($document->file_path)) }}"
                                                class="btn btn-info btn-sm me-2 mt-2 mb-2 btn-hover-info"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Preview"
                                                target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('documents.download', basename($document->file_path)) }}"
                                                class="btn btn-success btn-sm me-2 mt-2 mb-2 btn-hover-success"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            @if (auth()->user()->id === $document->uploaded_by)
                                                <a href="{{ route('documents.edit', $document->id) }}"
                                                    class="btn btn-warning btn-sm me-2 mt-2 mb-2 btn-hover-warning"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm mt-2 mb-2 btn-hover-danger btn-delete"
                                                    data-id="{{ $document->id }}" data-title="{{ $document->title }}"
                                                    data-url="{{ route('documents.destroy', $document->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
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

            <script src="{{ asset('template/dist/assets/extensions/jquery/jquery.min.js') }}"></script>
            <script src="{{ asset('template/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('template/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}">
            </script>
            <script src="{{ asset('template/dist/assets/static/js/pages/datatables.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert@2"></script>

            <script>
                $(document).ready(function() {
                    $('#documentTable').DataTable({
                        "paging": true,
                        "ordering": true,
                        "info": true,
                        "responsive": true,
                        "lengthMenu": [10, 25, 50, 100],
                        "dom": '<"d-flex justify-content-between"<"d-flex"l><"mt-4"f>>rt<"d-flex justify-content-between"<"d-flex"i><"ml-auto"p>> ',
                        "language": {
                            "search": "_INPUT_",
                            "searchPlaceholder": "Search..."
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

                $('form').submit(function(event) {
                    event.preventDefault();
                    const form = $(this);
                    swal({
                        title: "Apakah kamu yakin?",
                        text: "Dokumen ini akan dihapus secara permanen dan tidak dapat dipulihkan.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            form.unbind('submit').submit();
                        }
                    });
                });
            </script>
        </section>
    </div>
@endsection
