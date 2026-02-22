<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SI-KRONIS</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/sikronis.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sk-sidebar" id="sidebar">
        <div class="sk-sidebar-brand">
            <div class="brand-text">SI-KRONIS</div>
            <div class="brand-sub">Sistem Informasi Konsultasi Kronis</div>
        </div>

        <div class="sk-sidebar-menu">
            @php
                $role = auth()->user()->getRoleNames()->first();
            @endphp

            @if($role === 'admin')
                <div class="sk-sidebar-label">Dashboard</div>
                <a href="{{ route('admin.dashboard') }}" class="sk-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sk-sidebar-label">Manajemen Pengguna</div>
                <a href="{{ route('admin.users.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Data Pasien</span>
                </a>
                <a href="{{ route('admin.dokter.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.dokter*') ? 'active' : '' }}">
                    <i class="fas fa-user-doctor"></i>
                    <span>Data Dokter</span>
                </a>

                <div class="sk-sidebar-label">Konsultasi</div>
                <a href="{{ route('admin.konsultasi.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.konsultasi*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Semua Konsultasi</span>
                </a>

                <div class="sk-sidebar-label">Master Data</div>
                <a href="{{ route('admin.obat.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.obat*') ? 'active' : '' }}">
                    <i class="fas fa-pills"></i>
                    <span>Obat-obatan</span>
                </a>

                <div class="sk-sidebar-label">Laporan</div>
                <a href="{{ route('admin.laporan.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Statistik</span>
                </a>
            @endif

            @if($role === 'dokter')
                <div class="sk-sidebar-label">Dashboard</div>
                <a href="{{ route('dokter.dashboard') }}" class="sk-sidebar-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sk-sidebar-label">Konsultasi</div>
                <a href="{{ route('dokter.jadwal.index') }}" class="sk-sidebar-link {{ request()->routeIs('dokter.jadwal*') ? 'active' : '' }}">
                    <i class="fas fa-calendar"></i>
                    <span>Jadwal Saya</span>
                </a>
                <a href="{{ route('dokter.konsultasi.index') }}" class="sk-sidebar-link {{ request()->routeIs('dokter.konsultasi*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Daftar Konsultasi</span>
                </a>

                <div class="sk-sidebar-label">Resep</div>
                <a href="{{ route('dokter.resep.index') }}" class="sk-sidebar-link {{ request()->routeIs('dokter.resep*') ? 'active' : '' }}">
                    <i class="fas fa-prescription"></i>
                    <span>Resep Digital</span>
                </a>
            @endif

            @if($role === 'perawat')
                <div class="sk-sidebar-label">Dashboard</div>
                <a href="{{ route('perawat.dashboard') }}" class="sk-sidebar-link {{ request()->routeIs('perawat.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sk-sidebar-label">Konsultasi</div>
                <a href="{{ route('perawat.booking.index') }}" class="sk-sidebar-link {{ request()->routeIs('perawat.booking*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Konfirmasi Booking</span>
                </a>
            @endif

            <div class="sk-sidebar-label">Akun</div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sk-sidebar-link border-0 bg-transparent w-100 text-start">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="sk-main-content">
        <!-- Header -->
        <div class="sk-header">
            <button class="btn btn-link d-lg-none" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="ms-auto d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-link text-decoration-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text small text-muted">{{ ucfirst($role) }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
    
    @stack('scripts')
</body>
</html>
