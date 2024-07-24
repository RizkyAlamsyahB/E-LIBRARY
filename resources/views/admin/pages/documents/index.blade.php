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
                                    <th>Kode Klasifikasi</th> <!-- Kolom Kode Klasifikasi -->
                                    <th>Divisi</th> <!-- Kolom Divisi -->
                                    <th>Subbagian</th> <!-- Kolom Subbagian -->
                                    <th>Tanggal Pembuatan</th> <!-- Kolom Tanggal Pembuatan -->
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
                                        <!-- Menampilkan Kode Klasifikasi -->
                                        <td>{{ $document->division->name ?? 'N/A' }}</td> <!-- Menampilkan Divisi -->
                                        <td>{{ $document->subsection->name ?? 'N/A' }}</td> <!-- Menampilkan Subbagian -->
                                        <td>{{ $document->document_creation_date }}</td>
                                        <!-- Menampilkan Tanggal Pembuatan -->
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
                                                <form action="{{ route('documents.destroy', $document->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm mt-2 mb-2 btn-hover-danger"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
