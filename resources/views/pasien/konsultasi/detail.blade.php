@extends('layouts.pasien')
@section('title', 'Detail Konsultasi')

@section('content')
<div class="p-3">
    <div class="d-flex align-items-center gap-3 mb-4 animate-fade-in">
        <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h5 class="fw-bold mb-0">Detail Konsultasi</h5>
    </div>

    <div class="mobile-card animate-fade-in">
        <div class="d-flex justify-content-between mb-3">
            <span class="badge badge-{{ $booking->status }}">{{ $booking->status }}</span>
            <small class="text-muted">{{ $booking->kode_booking }}</small>
        </div>
        <div class="d-flex align-items-center mb-4">
            <div class="avatar avatar-lg avatar-primary me-3">{{ substr($booking->doctor->name, 0, 1) }}</div>
            <div>
                <h6 class="fw-bold mb-0">{{ $booking->doctor->name }}</h6>
                <small class="text-muted">{{ $booking->doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</small>
            </div>
        </div>
    </div>

    <div class="mobile-card animate-fade-in">
        <h6 class="fw-bold mb-3"><i class="fas fa-calendar me-2 text-primary"></i>Jadwal</h6>
        <div class="row">
            <div class="col-6 mb-3">
                <small class="text-muted d-block">Tanggal</small>
                <span class="fw-bold">{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d M Y') }}</span>
            </div>
            <div class="col-6 mb-3">
                <small class="text-muted d-block">Jam</small>
                <span class="fw-bold">{{ substr($booking->jam_mulai, 0, 5) }}</span>
            </div>
            <div class="col-6">
                <small class="text-muted d-block">Tipe</small>
                <span class="fw-bold">{{ ucfirst($booking->tipe_konsultasi) }}</span>
            </div>
            <div class="col-6">
                <small class="text-muted d-block">Kategori</small>
                <span class="fw-bold">{{ $booking->chronicCategory->nama ?? '-' }}</span>
            </div>
        </div>
    </div>

    @if($booking->keluhan)
    <div class="mobile-card animate-fade-in">
        <h6 class="fw-bold mb-3"><i class="fas fa-comment me-2 text-warning"></i>Keluhan</h6>
        <p class="mb-0">{{ $booking->keluhan }}</p>
    </div>
    @endif
</div>
@endsection
