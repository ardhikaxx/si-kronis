@extends('layouts.pasien')
@section('title', 'Detail Riwayat')

@section('content')
<div class="p-3">
    <div class="d-flex align-items-center gap-3 mb-4 animate-fade-in">
        <a href="{{ route('pasien.riwayat.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h5 class="fw-bold mb-0">Detail Konsultasi</h5>
    </div>

    <div class="mobile-card animate-fade-in">
        <div class="d-flex align-items-center mb-3">
            <div class="avatar avatar-lg avatar-primary me-3">{{ substr($consultation->doctor->name, 0, 1) }}</div>
            <div>
                <h6 class="fw-bold mb-0">{{ $consultation->doctor->name }}</h6>
                <small class="text-muted">{{ $consultation->doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</small>
            </div>
        </div>
        <small class="text-muted">{{ \Carbon\Carbon::parse($consultation->tanggal)->format('d F Y') }}</small>
    </div>

    @if($consultation->anamnesis)
    <div class="mobile-card animate-fade-in">
        <h6 class="fw-bold mb-3"><i class="fas fa-comment me-2 text-primary"></i>Anamnesis</h6>
        <p class="mb-0">{{ $consultation->anamnesis }}</p>
    </div>
    @endif

    @if($consultation->diagnosa)
    <div class="mobile-card animate-fade-in">
        <h6 class="fw-bold mb-3"><i class="fas fa-stethoscope me-2 text-danger"></i>Diagnosa</h6>
        <p class="mb-0">{{ $consultation->diagnosa }}</p>
        @if($consultation->icd_code)
        <small class="text-muted">Kode ICD: {{ $consultation->icd_code }}</small>
        @endif
    </div>
    @endif

    @if($consultation->rencana_terapi)
    <div class="mobile-card animate-fade-in">
        <h6 class="fw-bold mb-3"><i class="fas fa-pills me-2 text-success"></i>Rencana Terapi</h6>
        <p class="mb-0">{{ $consultation->rencana_terapi }}</p>
    </div>
    @endif
</div>
@endsection
