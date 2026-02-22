<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'SI-KRONIS')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/sikronis.css') }}" rel="stylesheet">
</head>
<body class="pasien-layout">

    <div class="sk-mobile-container">
        <!-- Top Header -->
        <nav class="navbar fixed-top navbar-dark bg-primary shadow-sm sk-mobile-header">
            <div class="container-fluid px-3">
                <a class="navbar-brand fw-bold" href="#">
                    <i class="fa-solid fa-hospital-user me-2"></i> SI-KRONIS
                </a>
                <div class="d-flex align-items-center text-white gap-3">
                    <i class="fa-regular fa-bell"></i>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-white p-0 text-decoration-none">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div style="padding-top: 70px; padding-bottom: 80px;" class="px-3">
            @yield('content')
        </div>

        <!-- Bottom Navigation -->
        <div class="sk-bottom-nav">
            <a href="{{ route('pasien.dashboard') }}" class="nav-item {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('pasien.konsultasi.index') }}" class="nav-item {{ request()->routeIs('pasien.konsultasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Konsultasi</span>
            </a>
            <a href="{{ route('pasien.riwayat.index') }}" class="nav-item {{ request()->routeIs('pasien.riwayat.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-medical"></i>
                <span>Riwayat</span>
            </a>
            <a href="{{ route('pasien.resep.index') }}" class="nav-item {{ request()->routeIs('pasien.resep.*') ? 'active' : '' }}">
                <i class="fa-solid fa-pills"></i>
                <span>Resep</span>
            </a>
            <a href="{{ route('pasien.profil.index') }}" class="nav-item {{ request()->routeIs('pasien.profil.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle"></i>
                <span>Profil</span>
            </a>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
