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
    
    <!-- Google Fonts - Premium -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/sikronis.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/improve.css') }}" rel="stylesheet">
    
    @stack('styles')
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sk-sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sk-sidebar" id="sidebar">
        <div class="sk-sidebar-brand">
            <div class="brand-text">
                <i class="fas fa-heart-pulse"></i>
                SI-KRONIS
            </div>
            <div class="brand-sub">Sistem Informasi Konsultasi Kronis</div>
        </div>

        <div class="sk-sidebar-menu">
            @php
                $role = auth()->user()->getRoleNames()->first();
                $userInitials = strtoupper(implode('', array_map(fn($word) => substr($word, 0, 1), explode(' ', auth()->user()->name))));
            @endphp

            @if($role === 'admin')
                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Dashboard</div>
                <a href="{{ route('admin.dashboard') }}" class="sk-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-grip"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Manajemen</div>
                <a href="{{ route('admin.users.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-user-group"></i>
                    <span>Data Pasien</span>
                </a>
                <a href="{{ route('admin.dokter.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.dokter*') ? 'active' : '' }}">
                    <i class="fas fa-user-md"></i>
                    <span>Data Dokter</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Konsultasi</div>
                <a href="{{ route('admin.konsultasi.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.konsultasi*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Semua Konsultasi</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Master Data</div>
                <a href="{{ route('admin.obat.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.obat*') ? 'active' : '' }}">
                    <i class="fas fa-pills"></i>
                    <span>Obat-obatan</span>
                </a>
                <a href="{{ route('admin.template-resep.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.template-resep*') ? 'active' : '' }}">
                    <i class="fas fa-file-medical"></i>
                    <span>Template Resep</span>
                </a>
                <a href="{{ route('admin.riwayat-medis.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.riwayat-medis*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i>
                    <span>Riwayat Medis</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Laporan</div>
                <a href="{{ route('admin.laporan.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Statistik</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Akun</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sk-sidebar-link border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @endif

            @if($role === 'dokter')
                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Dashboard</div>
                <a href="{{ route('dokter.dashboard') }}" class="sk-sidebar-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-grip"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Konsultasi</div>
                <a href="{{ route('dokter.jadwal.index') }}" class="sk-sidebar-link {{ request()->routeIs('dokter.jadwal*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Jadwal Saya</span>
                </a>
                <a href="{{ route('dokter.konsultasi.index') }}" class="sk-sidebar-link {{ request()->routeIs('dokter.konsultasi*') ? 'active' : '' }}">
                    <i class="fas fa-stethoscope"></i>
                    <span>Daftar Konsultasi</span>
                </a>
                <a href="{{ route('admin.template-resep.index') }}" class="sk-sidebar-link {{ request()->routeIs('admin.template-resep*') ? 'active' : '' }}">
                    <i class="fas fa-file-medical"></i>
                    <span>Template Resep</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Resep</div>
                <a href="{{ route('dokter.resep.index') }}" class="sk-sidebar-link {{ request()->routeIs('dokter.resep*') ? 'active' : '' }}">
                    <i class="fas fa-prescription-bottle"></i>
                    <span>Resep Digital</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Komunikasi</div>
                <a href="{{ route('dokter.chat.index') }}" class="sk-sidebar-link {{ request()->routeIs('dokter.chat*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    <span>Chat Pasien</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Akun</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sk-sidebar-link border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @endif

            @if($role === 'perawat')
                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Dashboard</div>
                <a href="{{ route('perawat.dashboard') }}" class="sk-sidebar-link {{ request()->routeIs('perawat.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-grip"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Konsultasi</div>
                <a href="{{ route('perawat.booking.index') }}" class="sk-sidebar-link {{ request()->routeIs('perawat.booking*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Konfirmasi Booking</span>
                </a>
                <a href="{{ route('perawat.lab.index') }}" class="sk-sidebar-link {{ request()->routeIs('perawat.lab*') ? 'active' : '' }}">
                    <i class="fas fa-flask"></i>
                    <span>Laboratorium</span>
                </a>

                <div class="sk-sidebar-label"><i class="fas fa-minus"></i>Akun</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sk-sidebar-link border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="sk-main-content">
        <!-- Topbar -->
        <div class="sk-header">
            <button class="sk-header-toggle" id="sidebarToggle">
                <i class="fas fa-bars-staggered"></i>
            </button>
            
            <div class="sk-header-search">
                @php
                    $role = auth()->user()->getRoleNames()->first();
                    $searchRoute = $role . '.search';
                @endphp
                <form action="{{ route($searchRoute) }}" method="GET" class="sk-header-search-wrapper">
                    <input type="text" name="q" placeholder="Cari pasien, dokter, atau menu..." value="{{ request('q') }}">
                    <i class="fas fa-magnifying-glass"></i>
                </form>
            </div>
            
            <div class="sk-header-actions">
                <!-- Help Button -->
                <button class="sk-header-icon-btn" title="Bantuan">
                    <i class="far fa-circle-question"></i>
                </button>
                
                <!-- Quick Actions -->
                <div class="sk-header-quick-actions">
                    <button class="sk-header-quick-btn" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-plus"></i>
                        <span>Buat Baru</span>
                    </button>
                    <div class="dropdown-menu sk-dropdown-menu">
                        <a class="sk-dropdown-item" href="{{ route('admin.users.create') }}">
                            <i class="fas fa-user-plus"></i>
                            <span>Tambah Pasien</span>
                        </a>
                        <a class="sk-dropdown-item" href="{{ route('admin.konsultasi.index') }}">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Konsultasi Baru</span>
                        </a>
                        <div class="sk-dropdown-divider"></div>
                        <a class="sk-dropdown-item" href="{{ route('admin.laporan.index') }}">
                            <i class="fas fa-file-export"></i>
                            <span>Export Laporan</span>
                        </a>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="sk-header-profile">
                    <button class="sk-header-profile-btn" type="button" data-bs-toggle="dropdown">
                        <div class="sk-header-profile-avatar">{{ $userInitials }}</div>
                        <div class="sk-header-profile-info d-none d-md-block">
                            <div class="sk-header-profile-name">{{ auth()->user()->name }}</div>
                            <div class="sk-header-profile-role">{{ ucfirst($role) }}</div>
                        </div>
                        <i class="fas fa-chevron-down sk-header-profile-chevron"></i>
                    </button>
                    <div class="dropdown-menu sk-dropdown-menu">
                        <div class="sk-dropdown-header">
                            <div class="sk-dropdown-header-title">{{ auth()->user()->name }}</div>
                            <div class="sk-dropdown-header-subtitle">{{ auth()->user()->email }}</div>
                        </div>
                        <a class="sk-dropdown-item" href="#">
                            <i class="fas fa-user"></i>
                            <span>Profil Saya</span>
                        </a>
                        <a class="sk-dropdown-item" href="#">
                            <i class="fas fa-gear"></i>
                            <span>Pengaturan</span>
                        </a>
                        <a class="sk-dropdown-item" href="#">
                            <i class="fas fa-shield-halved"></i>
                            <span>Keamanan</span>
                        </a>
                        <div class="sk-dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="sk-dropdown-item danger">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);">
                    <i class="fas fa-exclamation-triangle me-2"></i>
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
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        }

        sidebarToggle?.addEventListener('click', toggleSidebar);
        sidebarOverlay?.addEventListener('click', toggleSidebar);

        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
