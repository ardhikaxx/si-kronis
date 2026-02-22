@extends('layouts.pasien')

@section('title', 'Dashboard')

@section('content')
<div class="p-3">
    <!-- Welcome Section -->
    <div class="mb-4">
        <h5 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name }}!</h5>
        <p class="text-muted small mb-0">Kelola kesehatan Anda dengan mudah</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="card sk-card">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check text-primary" style="font-size: 32px;"></i>
                    <h3 class="fw-bold mt-2 mb-0">{{ $stats['upcoming_bookings'] }}</h3>
                    <small class="text-muted">Jadwal Mendatang</small>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card sk-card">
                <div class="card-body text-center">
                    <i class="fas fa-file-medical text-success" style="font-size: 32px;"></i>
                    <h3 class="fw-bold mt-2 mb-0">{{ $stats['total_consultations'] }}</h3>
                    <small class="text-muted">Total Konsultasi</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Chronic Conditions -->
    @if($chronicConditions->count() > 0)
    <div class="card sk-card mb-4">
        <div class="sk-card-header">
            <i class="fas fa-heartbeat me-2"></i>Kondisi Kronis Saya
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                @foreach($chronicConditions as $condition)
                <span class="chronic-badge" style="background: {{ $condition->chronicCategory->warna }}20; color: {{ $condition->chronicCategory->warna }};">
                    <i class="fas {{ $condition->chronicCategory->icon }}"></i>
                    {{ $condition->chronicCategory->nama }}
                </span>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Upcoming Bookings -->
    @if($upcomingBookings->count() > 0)
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">Jadwal Konsultasi</h6>
            <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-sm btn-link">Lihat Semua</a>
        </div>

        @foreach($upcomingBookings as $booking)
        <div class="card sk-card booking-card status-{{ $booking->status }} mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="fw-bold mb-1">{{ $booking->doctor->name }}</h6>
                        <small class="text-muted">{{ $booking->doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</small>
                    </div>
                    <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                </div>
                <div class="d-flex gap-3 mt-2">
                    <small><i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d M Y') }}</small>
                    <small><i class="fas fa-clock me-1"></i>{{ substr($booking->jam_mulai, 0, 5) }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="card sk-card mb-4">
        <div class="card-body text-center py-4">
            <i class="fas fa-calendar-xmark text-muted" style="font-size: 48px;"></i>
            <p class="text-muted mt-3 mb-3">Belum ada jadwal konsultasi</p>
            <a href="{{ route('pasien.konsultasi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i>Buat Booking
            </a>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="mb-4">
        <h6 class="fw-bold mb-3">Aksi Cepat</h6>
        <div class="row g-2">
            <div class="col-6">
                <a href="{{ route('pasien.konsultasi.create') }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-calendar-plus d-block mb-2" style="font-size: 24px;"></i>
                    <small>Booking Konsultasi</small>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('pasien.riwayat.index') }}" class="btn btn-outline-success w-100">
                    <i class="fas fa-history d-block mb-2" style="font-size: 24px;"></i>
                    <small>Riwayat Medis</small>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
