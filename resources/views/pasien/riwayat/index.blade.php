@extends('layouts.pasien')

@section('title', 'Riwayat Konsultasi')

@section('content')
<div class="p-3">
    <h5 class="fw-bold mb-3">Riwayat Konsultasi</h5>

    @forelse($consultations as $consultation)
    <div class="card sk-card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h6 class="fw-bold mb-1">{{ $consultation->doctor->name }}</h6>
                    <small class="text-muted">{{ $consultation->doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</small>
                </div>
                <span class="badge bg-success">Selesai</span>
            </div>
            
            <div class="mb-2">
                <small class="text-muted">
                    <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($consultation->tanggal)->format('d M Y') }}
                </small>
            </div>

            @if($consultation->diagnosa)
            <div class="mb-2">
                <strong class="small">Diagnosa:</strong>
                <p class="small mb-0">{{ Str::limit($consultation->diagnosa, 100) }}</p>
            </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('pasien.riwayat.show', $consultation->id) }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="fas fa-eye me-1"></i>Lihat Detail
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="card sk-card">
        <div class="card-body text-center py-5">
            <i class="fas fa-file-medical text-muted" style="font-size: 48px;"></i>
            <p class="text-muted mt-3">Belum ada riwayat konsultasi</p>
        </div>
    </div>
    @endforelse

    @if($consultations->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan {{ $consultations->firstItem() ?? 0 }} - {{ $consultations->lastItem() ?? 0 }} dari {{ $consultations->total() }} data
        </div>
        {{ $consultations->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
