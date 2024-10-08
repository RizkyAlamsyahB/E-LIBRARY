@extends('layouts.app')

@section('title', 'Di Bawah Kekuasaan ')

@section('main-content')
    <div class="page-content" style="display: none;">
        <section class="row position-relative">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Di Bawah Kekuasaan </h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Di Bawah Kekuasaan</li>
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
                        <a href="{{ route('person_in_charge.create') }}" class="btn btn-primary mb-3 rounded-pill">+
                            Tambah</a>
                        <table class="table table-striped" id="personsInChargeTable">
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
    <script src="{{ asset('template/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('template/dist/assets/static/js/pages/datatables.js') }}"></script>
    <link rel="stylesheet"
        href="{{ asset('template/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

    <script>
        $(document).ready(function() {
            var table = $('#personsInChargeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('person_in_charge.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
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
        });

        // Function to dynamically generate and append delete modal
        function createDeleteModal(id, name) {
            return `
                <div class="modal fade" id="deleteModal${id}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel${id}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title text-white" id="deleteModalLabel${id}">Konfirmasi Penghapusan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus data <strong>${name}</strong>?
                            </div>
                            <div class="modal-footer">
                                <form action="{{ url('person_in_charge') }}/${id}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Listen for DataTables draw event to create modals
        $('#personsInChargeTable').on('draw.dt', function() {
            var table = $('#personsInChargeTable').DataTable();
            var data = table.rows().data();

            data.each(function(row) {
                var modalHtml = createDeleteModal(row.id, row.name);
                if (!document.querySelector(`#deleteModal${row.id}`)) {
                    $('body').append(modalHtml);
                }
            });
        });
    </script>
@endsection
