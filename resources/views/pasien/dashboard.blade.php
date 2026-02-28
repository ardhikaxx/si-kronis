@extends('layouts.pasien')

@section('title', 'Dashboard')

@section('content')
<div class="p-3">
    <!-- Welcome Section -->
    <div class="mobile-card animate-fade-in">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-1">Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h5>
                <p class="text-muted small mb-0">Kesehatan Anda prioritas kami</p>
            </div>
            <div class="avatar avatar-lg avatar-primary">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="mobile-card text-center animate-fade-in animate-delay-1">
                <div class="avatar avatar-primary mx-auto mb-3" style="width: 56px; height: 56px;">
                    <i class="fas fa-calendar-check" style="font-size: 24px;"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $stats['upcoming_bookings'] }}</h3>
                <small class="text-muted">Jadwal Mendatang</small>
            </div>
        </div>
        <div class="col-6">
            <div class="mobile-card text-center animate-fade-in animate-delay-2">
                <div class="avatar avatar-success mx-auto mb-3" style="width: 56px; height: 56px;">
                    <i class="fas fa-file-medical" style="font-size: 24px;"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $stats['total_consultations'] }}</h3>
                <small class="text-muted">Total Konsultasi</small>
            </div>
        </div>
    </div>

    <!-- Chronic Conditions -->
    @if($chronicConditions->count() > 0)
    <div class="mobile-card animate-fade-in animate-delay-3">
        <div class="mobile-card-header">
            <h6 class="mobile-card-title mb-0">
                <i class="fas fa-heartbeat text-danger me-2"></i>Kondisi Kronis
            </h6>
        </div>
        <div class="d-flex flex-wrap gap-2">
            @foreach($chronicConditions as $condition)
            <span class="chronic-badge" style="background: {{ $condition->chronicCategory->warna }}20; color: {{ $condition->chronicCategory->warna }};">
                <i class="fas {{ $condition->chronicCategory->icon }}"></i>
                {{ $condition->chronicCategory->nama }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Upcoming Bookings -->
    <div class="mb-4 animate-fade-in animate-delay-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">
                <i class="fas fa-calendar text-primary me-2"></i>Jadwal Konsultasi
            </h6>
            <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-sm btn-link">Lihat Semua</a>
        </div>

        @if($upcomingBookings->count() > 0)
            @foreach($upcomingBookings as $booking)
            <div class="mobile-card booking-card status-{{ $booking->status }}">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-primary me-3">
                            {{ substr($booking->doctor->name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">{{ $booking->doctor->name }}</h6>
                            <small class="text-muted">{{ $booking->doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</small>
                        </div>
                    </div>
                    @if($booking->status == 'pending')
                        <span class="badge badge-pending">Menunggu</span>
                    @elseif($booking->status == 'confirmed')
                        <span class="badge badge-confirmed">Dikonfirmasi</span>
                    @elseif($booking->status == 'completed')
                        <span class="badge badge-completed">Selesai</span>
                    @else
                        <span class="badge badge-cancelled">Dibatalkan</span>
                    @endif
                </div>
                <div class="d-flex gap-3 text-muted">
                    <small><i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d M Y') }}</small>
                    <small><i class="fas fa-clock me-1"></i>{{ substr($booking->jam_mulai, 0, 5) }}</small>
                </div>
            </div>
            @endforeach
        @else
            <div class="mobile-card text-center py-4">
                <i class="fas fa-calendar-xmark text-muted" style="font-size: 48px;"></i>
                <p class="text-muted mt-3 mb-3">Belum ada jadwal konsultasi</p>
                <a href="{{ route('pasien.konsultasi.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Buat Booking
                </a>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="animate-fade-in">
        <h6 class="fw-bold mb-3">
            <i class="fas fa-bolt text-warning me-2"></i>Aksi Cepat
        </h6>
        <div class="row g-3">
            <div class="col-6">
                <a href="{{ route('pasien.konsultasi.create') }}" class="mobile-card text-center text-decoration-none">
                    <div class="avatar avatar-primary mx-auto mb-2">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <small class="text-dark fw-bold">Booking<br>Konsultasi</small>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('pasien.riwayat.index') }}" class="mobile-card text-center text-decoration-none">
                    <div class="avatar avatar-success mx-auto mb-2">
                        <i class="fas fa-history"></i>
                    </div>
                    <small class="text-dark fw-bold">Riwayat<br>Medis</small>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('pasien.resep.index') }}" class="mobile-card text-center text-decoration-none">
                    <div class="avatar avatar-warning mx-auto mb-2">
                        <i class="fas fa-prescription"></i>
                    </div>
                    <small class="text-dark fw-bold">Resep<br>Saya</small>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('pasien.chat.index') }}" class="mobile-card text-center text-decoration-none">
                    <div class="avatar avatar-info mx-auto mb-2">
                        <i class="fas fa-comments"></i>
                    </div>
                    <small class="text-dark fw-bold">Chat<br>Dokter</small>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
