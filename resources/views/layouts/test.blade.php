<div id="main" class='layout-navbar navbar-fixed' style="display: none;">
        <header>
            <nav class="navbar navbar-expand navbar-light navbar-top">
                <div class="container-fluid">
                    <a href="#" class="burger-btn d-block">
                        <i class="bi bi-justify fs-3"></i>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                        </ul>
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-menu d-flex">
                                    <div class="user-name text-end me-3">
                                        <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                                        <p class="mb-0 text-sm text-gray-900">
                                            @if (Auth::user()->division)
                                                <strong>{{ Auth::user()->division->name }}</strong>
                                            @endif
                                        </p>


                                    </div>
                                    <div class="user-img d-flex align-items-center">
                                        <div class="avatar avatar-md">
                                            <img
                                                src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('template/dist/assets/compiled/jpg/user.png') }}">
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                style="min-width: 11rem;">
                                <li>
                                    <h6 class="dropdown-header">Hallo, {{ Auth::user()->name }}!</h6>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="icon-mid bi bi-person me-2"></i> Profil Saya
                                    </a>
                                </li>


                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <!-- Logout Form -->
                                <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                    style="display: none;">
                                    @csrf
                                </form>

                                <!-- Logout Link -->
                                <li>
                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="icon-mid bi bi-box-arrow-left me-2"></i> Keluar
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

        </header>
        <div id="main-content">

            <div class="page-heading">
                <section class="section">
                    @yield('main-content')
                </section>

            </div>



        </div>

    </div>

     <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}">
                        <a href="/dashboard" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('documents') ? 'active' : '' }}">
                        <a href="{{ route('documents.index') }}" class='sidebar-link'>
                            <i class="bi bi-file-earmark-fill"></i>
                            <span>Dokumen</span>
                        </a>
                    </li>
                    {{-- <li class="sidebar-title">Pages</li>

                    <li class="sidebar-item {{ Request::is('profile') || Request::is('profile*') ? 'active' : '' }}">
                        <a href="{{ route('profile.edit') }}" class='sidebar-link'>
                            <i class="bi bi-person-circle"></i>
                            <span>Account</span>
                        </a>
                    </li> --}}
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <li class="sidebar-title">Master Data</li>

                        <li
                            class="sidebar-item {{ Request::is('employees') || Request::is('employees*') ? 'active' : '' }}">
                            <a href="{{ route('employees.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Pegawai</span>
                            </a>
                        </li>

                        <li
                            class="sidebar-item {{ Request::is('classification-codes') || Request::is('classification-codes*') ? 'active' : '' }}">
                            <a href="{{ route('classification-codes.index') }}" class='sidebar-link'>
                                <i class="bi bi-person-fill-gear"></i>
                                <span>Kode Klasifikasi</span>
                            </a>
                        </li>

                        <li
                            class="sidebar-item {{ Request::is('documents-status') || Request::is('documents-status*') ? 'active' : '' }}">
                            <a href="{{ route('document_status.index') }}" class='sidebar-link'>
                                <i class="bi bi-file-earmark-bar-graph-fill"></i>
                                <span>Sifat Dokumen</span>
                            </a>
                        </li>

                        <li
                            class="sidebar-item {{ Request::is('person_in_charge') || Request::is('person_in_charge*') ? 'active' : '' }}">
                            <a href="{{ route('person_in_charge.index') }}" class='sidebar-link'>
                                <i class="bi bi-file-earmark-person-fill"></i>
                                <span>Di Bawah Kekuasaan</span>
                            </a>
                        </li>

                        <li
                            class="sidebar-item {{ Request::is('divisions') || Request::is('divisions*') ? 'active' : '' }}">
                            <a href="{{ route('divisions.index') }}" class='sidebar-link'>
                                <i class="bi bi-briefcase-fill"></i>
                                <span>Jabatan</span>
                            </a>
                        </li>

                        <li
                            class="sidebar-item {{ Request::is('subsections') || Request::is('subsections*') ? 'active' : '' }}">
                            <a href="{{ route('subsections.index') }}" class='sidebar-link'>
                                <i class="bi bi-list-check"></i>
                                <span>Sub Bagian</span>
                            </a>
                        </li>
                    @endif

                    <li class="sidebar-item {{ Request::is('profile') ? 'active' : '' }}">
                        <a href="{{ route('profile.edit') }}" class='sidebar-link'>
                            <i class="bi bi-person-circle"></i>
                            <span>Profil</span>
                        </a>
                    </li>





                </ul>
            </div>
<link rel="stylesheet" crossorigin href="{{ asset('template/dist/assets/compiled/css/app.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('template/dist/assets/compiled/css/app-dark.css') }}">
<script src="{{ asset('template/dist/assets/static/js/initTheme.js') }}"></script>
<script src="{{ asset('template/dist/assets/static/js/components/dark.js') }}"></script>
<script src="{{ asset('template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

<script src="{{ asset('template/dist/assets/compiled/js/app.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // const loadingElement = document.getElementById('app');
        // const loadingElement = document.getElementById('loading');
        const sidebarElement = document.getElementById('sidebar');
        const contentElement = document.querySelector('.page-content');
        const navbarElement = document.getElementById('main');

        // loadingElement.style.display = 'none'; // Sembunyikan elemen loading
        sidebarElement.style.display = 'block'; // Tampilkan sidebar
        navbarElement.style.display = 'block'; // Tampilkan navbar
        contentElement.style.display = 'block'; // Tampilkan konten utama
    });
</script>
