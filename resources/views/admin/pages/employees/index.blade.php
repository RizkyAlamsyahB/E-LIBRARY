@extends('layouts.app')

@section('title', 'Pegawai')

@section('main-content')
    <div class="page-content" style="display: none;">
        <section class="row position-relative">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pegawai</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
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
                        <!-- Button to add a new employee -->
                        <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3 rounded-pill">+ Tambah</a>
                        <table class="table table-striped" id="employeeTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jabatan</th>
                                    <th>Sub Bagian</th>
                                    <th>Role</th>
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
        document.addEventListener("DOMContentLoaded", function() {
            const loadingElement = document.getElementById('loading'); // Pastikan elemen ini ada jika digunakan
            const contentElement = document.querySelector('.page-content');

            // Sembunyikan elemen loading dan tampilkan konten
            if (loadingElement) {
                loadingElement.style.display = 'none';
            }
            if (contentElement) {
                contentElement.style.display = 'block';
            }

            // Inisialisasi DataTables setelah konten ditampilkan
            $('#employeeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employees.index') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'division.name',
                        name: 'division.name'
                    },
                    {
                        data: 'subsections',
                        name: 'subsections'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
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

            // Hide alert after 2 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 2000);


            // JavaScript for Delete Confirmation Modal
            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var employeeId = button.data('id'); // Extract info from data-* attributes
                var employeeName = button.data('name');
                var actionUrl = '{{ route('employees.destroy', ':id') }}'.replace(':id', employeeId);

                var modal = $(this);
                modal.find('#deleteForm').attr('action', actionUrl);
                modal.find('#deleteDocumentTitle').text(employeeName);
            });
        });
    </script>
@endsection
