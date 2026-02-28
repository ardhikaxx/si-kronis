@extends('layouts.pasien')

@section('title', 'Riwayat Konsultasi')

@section('content')
<div class="p-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h5 class="fw-bold mb-0">Riwayat Konsultasi</h5>
            <small class="text-muted">Lihat semua riwayat treatment Anda</small>
        </div>
        <a href="{{ route('pasien.riwayat.export-pdf') }}" class="btn btn-danger btn-sm">
            <i class="fas fa-file-pdf me-1"></i>PDF
        </a>
    </div>

    @forelse($consultations as $consultation)
    <div class="mobile-card animate-fade-in">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-primary me-3">
                    {{ substr($consultation->doctor->name, 0, 1) }}
                </div>
                <div>
                    <h6 class="fw-bold mb-0">{{ $consultation->doctor->name }}</h6>
                    <small class="text-muted">{{ $consultation->doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</small>
                </div>
            </div>
            <span class="badge badge-completed">Selesai</span>
        </div>
        
        <div class="mb-3">
            <small class="text-muted d-block mb-1">
                <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($consultation->tanggal)->format('d M Y') }}
            </small>
            @if($consultation->diagnosa)
            <div class="mt-2 p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Diagnosa:</small>
                <p class="mb-0 small">{{ Str::limit($consultation->diagnosa, 100) }}</p>
            </div>
            @endif
        </div>

        <a href="{{ route('pasien.riwayat.show', $consultation->id) }}" class="btn btn-outline-primary btn-sm w-100">
            <i class="fas fa-eye me-1"></i>Lihat Detail
        </a>
    </div>
    @empty
    <div class="mobile-card text-center py-5">
        <i class="fas fa-file-medical text-muted" style="font-size: 64px;"></i>
        <h6 class="mt-3">Belum Ada Riwayat</h6>
        <p class="text-muted mb-3">Anda belum pernah melakukan konsultasi</p>
        <a href="{{ route('pasien.konsultasi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Mulai Konsultasi
        </a>
    </div>
    @endforelse

    @if($consultations->hasPages())
    <div class="pagination-wrapper mt-4">
        {{ $consultations->links('pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
