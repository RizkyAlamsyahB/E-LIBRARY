@extends('layouts.app')

@section('main-content')
    <div class="page-content">
        <section class="row position-relative">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Divisi</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Divisi</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show position-fixed rounded-pill"
                    style="bottom: 1rem; right: 1rem; z-index: 1050; max-width: 90%; width: auto;" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close " data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{ route('divisions.create') }}" class="btn btn-primary mb-3 rounded-pill">+ Tambah</a>
                        <table class="table table-striped" id="divisionTable" border="1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($divisions as $division)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $division->name }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('divisions.edit', $division->id) }}"
                                                class="btn btn-warning btn-sm me-2 mt-2 mb-2 btn-hover-warning"
                                                data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('divisions.destroy', $division->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm mt-2 mb-2 btn-hover-danger"
                                                    data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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

            <script>
                $(document).ready(function() {
                    $('#divisionTable').DataTable({
                        "paging": true,
                        // "searching": true,
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

                    // Hide the success alert after 5 seconds
                    setTimeout(function() {
                        $('.alert').fadeOut('slow');
                    }, 2000);
                });

                $(document).ready(function() {
                    $('[data-toggle="tooltip"]').tooltip();
                });

                $('form').submit(function(event) {
                    event.preventDefault();
                    const form = $(this);
                    swal({
                        title: "Apakah kamu yakin?",
                        text: "Divisi    ini akan dihapus secara permanen dan tidak dapat dipulihkan.",
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
