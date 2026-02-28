@extends('layouts.pasien')

@section('title', 'Konsultasi Saya')

@section('content')
<div class="p-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h5 class="fw-bold mb-0">Konsultasi Saya</h5>
            <small class="text-muted">Kelola jadwal konsultasi Anda</small>
        </div>
        <a href="{{ route('pasien.konsultasi.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Booking Baru
        </a>
    </div>

    @forelse($bookings as $booking)
    <div class="mobile-card animate-fade-in">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <small class="text-muted">{{ $booking->kode_booking }}</small>
                <h6 class="fw-bold mb-1">{{ $booking->doctor->name }}</h6>
                <small class="text-muted">{{ $booking->doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</small>
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
        
        <div class="d-flex gap-3 mb-3 text-muted">
            <small><i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d M Y') }}</small>
            <small><i class="fas fa-clock me-1"></i>{{ substr($booking->jam_mulai, 0, 5) }}</small>
        </div>

        @if($booking->chronicCategory)
        <div class="mb-3">
            <span class="chronic-badge" style="background: {{ $booking->chronicCategory->warna }}20; color: {{ $booking->chronicCategory->warna }};">
                <i class="fas {{ $booking->chronicCategory->icon }}"></i>
                {{ $booking->chronicCategory->nama }}
            </span>
        </div>
        @endif

        <a href="{{ route('pasien.konsultasi.show', $booking->id) }}" class="btn btn-outline-primary btn-sm w-100">
            <i class="fas fa-eye me-1"></i>Lihat Detail
        </a>
    </div>
    @empty
    <div class="mobile-card text-center py-5">
        <i class="fas fa-calendar-xmark text-muted" style="font-size: 64px;"></i>
        <h6 class="mt-3">Belum Ada Konsultasi</h6>
        <p class="text-muted mb-3">Buat jadwal konsultasi pertama Anda</p>
        <a href="{{ route('pasien.konsultasi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Buat Booking
        </a>
    </div>
    @endforelse

    @if($bookings->hasPages())
    <div class="pagination-wrapper mt-4">
        {{ $bookings->links('pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
