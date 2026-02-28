@extends('layouts.pasien')
@section('title', 'Detail Resep')

@section('content')
<div class="p-3">
    <div class="d-flex align-items-center gap-3 mb-4 animate-fade-in">
        <a href="{{ route('pasien.resep.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h5 class="fw-bold mb-0">Detail Resep</h5>
    </div>

    <div class="mobile-card animate-fade-in">
        <div class="d-flex justify-content-between mb-3">
            <span class="badge badge-{{ $prescription->status == 'active' ? 'confirmed' : 'pending' }}">{{ $prescription->status }}</span>
            <small class="text-muted">{{ $prescription->kode_resep }}</small>
        </div>
        <div class="mb-3">
            <small class="text-muted d-block">Dokter</small>
            <span class="fw-bold">{{ $prescription->doctor->name }}</span>
        </div>
        <div class="mb-3">
            <small class="text-muted d-block">Tanggal</small>
            <span class="fw-bold">{{ \Carbon\Carbon::parse($prescription->tanggal_resep)->format('d F Y') }}</span>
        </div>
    </div>

    <div class="mobile-card animate-fade-in">
        <h6 class="fw-bold mb-3"><i class="fas fa-pills me-2 text-primary"></i>Daftar Obat</h6>
        @forelse($prescription->prescriptionItems as $item)
        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
            <div>
                <span class="fw-bold">{{ $item->medicine->nama ?? '-' }}</span>
                <small class="text-muted d-block">{{ $item->dosis }}</small>
            </div>
            <span class="badge badge-completed">{{ $item->jumlah }}</span>
        </div>
        @empty
        <p class="text-muted">Tidak ada obat</p>
        @endforelse
    </div>
</div>
@endsection
