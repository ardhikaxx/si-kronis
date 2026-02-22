@extends('layouts.pasien')
@section('title', 'Detail Konsultasi')

@section('content')
    <div class="mb-4 d-flex align-items-center gap-3">
        <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h5 class="fw-bold mb-0">Detail Konsultasi</h5>
    </div>

    <!-- Booking Info -->
    <div class="card sk-card border-0 bg-white mb-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between mb-3">
                <span class="badge badge-{{ $booking->status }} rounded-pill px-3 py-1 text-capitalize">
                    {{ $booking->status }}
                </span>
                <small class="text-muted text-uppercase fw-bold">{{ $booking->kode_booking }}</small>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                    <i class="fa-solid fa-user-doctor text-primary fa-xl"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">{{ $booking->doctor->name ?? 'Dokter' }}</h5>
                    <p class="small text-muted mb-0">{{ $booking->doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</p>
                </div>
            </div>

            <hr class="border-secondary opacity-10 my-3">

            <div class="row g-3 small">
                <div class="col-6">
                    <label class="text-muted d-block mb-1">Tanggal</label>
                    <span class="fw-bold">{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d M Y') }}</span>
                </div>
                <div class="col-6">
                    <label class="text-muted d-block mb-1">Waktu</label>
                    <span class="fw-bold">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }} WIB</span>
                </div>
                <div class="col-12">
                    <label class="text-muted d-block mb-1">Keluhan</label>
                    <p class="mb-0 fw-medium">{{ $booking->keluhan }}</p>
                </div>
                @if($booking->chronicCategory)
                <div class="col-12">
                    <label class="text-muted d-block mb-1">Kategori</label>
                    <span class="badge bg-light text-dark border">{{ $booking->chronicCategory->nama }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($booking->status == 'completed' && $booking->consultation)
    <!-- Hasil Konsultasi (Jika Selesai) -->
    <div class="card sk-card border-0 bg-white mb-3">
        <div class="card-header bg-success text-white py-3">
            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-file-medical me-2"></i> Hasil Medis</h6>
        </div>
        <div class="card-body p-4">
            <div class="mb-3">
                <label class="small text-muted fw-bold text-uppercase">Diagnosa</label>
                <p class="mb-0">{{ $booking->consultation->diagnosa ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <label class="small text-muted fw-bold text-uppercase">Saran Dokter</label>
                <p class="mb-0">{{ $booking->consultation->saran_dokter ?? '-' }}</p>
            </div>
            
            @if($booking->consultation->prescription)
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="d-block text-muted">Resep Obat</small>
                        <span class="fw-bold text-primary">{{ $booking->consultation->prescription->kode_resep }}</span>
                    </div>
                    <a href="{{ route('pasien.resep.show', $booking->consultation->prescription->id) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                        Lihat Resep
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endif
@endsection
