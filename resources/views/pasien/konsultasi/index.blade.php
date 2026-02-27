@extends('layouts.pasien')

@section('title', 'Konsultasi Saya')

@section('content')
<div class="p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Konsultasi Saya</h5>
        <a href="{{ route('pasien.konsultasi.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Booking Baru
        </a>
    </div>

    @forelse($bookings as $booking)
    <div class="card sk-card booking-card status-{{ $booking->status }} mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <small class="text-muted">{{ $booking->kode_booking }}</small>
                    <h6 class="fw-bold mb-1">{{ $booking->doctor->name }}</h6>
                    <small class="text-muted">{{ $booking->doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</small>
                </div>
                <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
            </div>
            
            <div class="d-flex gap-3 mt-2 mb-2">
                <small><i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d M Y') }}</small>
                <small><i class="fas fa-clock me-1"></i>{{ substr($booking->jam_mulai, 0, 5) }}</small>
                <small><i class="fas fa-laptop me-1"></i>{{ ucfirst($booking->tipe_konsultasi) }}</small>
            </div>

            @if($booking->chronicCategory)
            <div class="mb-2">
                <span class="chronic-badge" style="background: {{ $booking->chronicCategory->warna }}20; color: {{ $booking->chronicCategory->warna }};">
                    <i class="fas {{ $booking->chronicCategory->icon }}"></i>
                    {{ $booking->chronicCategory->nama }}
                </span>
            </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('pasien.konsultasi.show', $booking->id) }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="fas fa-eye me-1"></i>Lihat Detail
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="card sk-card">
        <div class="card-body text-center py-5">
            <i class="fas fa-calendar-xmark text-muted" style="font-size: 48px;"></i>
            <p class="text-muted mt-3 mb-3">Belum ada konsultasi</p>
            <a href="{{ route('pasien.konsultasi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Buat Booking
            </a>
        </div>
    </div>
    @endforelse

    @if($bookings->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan {{ $bookings->firstItem() ?? 0 }} - {{ $bookings->lastItem() ?? 0 }} dari {{ $bookings->total() }} data
        </div>
        {{ $bookings->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
