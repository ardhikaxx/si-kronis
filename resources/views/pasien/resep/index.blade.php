@extends('layouts.pasien')

@section('title', 'Resep Digital')

@section('content')
<div class="p-3">
    <h5 class="fw-bold mb-3">Resep Digital</h5>

    @forelse($prescriptions as $prescription)
    <div class="card sk-card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <small class="text-muted">{{ $prescription->kode_resep }}</small>
                    <h6 class="fw-bold mb-1">{{ $prescription->doctor->name }}</h6>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($prescription->tanggal_resep)->format('d M Y') }}</small>
                </div>
                <span class="badge badge-{{ $prescription->status }}">{{ ucfirst($prescription->status) }}</span>
            </div>

            <div class="mb-2">
                <small class="text-muted">{{ $prescription->items->count() }} item obat</small>
            </div>

            <div class="mt-3">
                <a href="{{ route('pasien.resep.show', $prescription->id) }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="fas fa-eye me-1"></i>Lihat Resep
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="card sk-card">
        <div class="card-body text-center py-5">
            <i class="fas fa-pills text-muted" style="font-size: 48px;"></i>
            <p class="text-muted mt-3">Belum ada resep</p>
        </div>
    </div>
    @endforelse

    @if($prescriptions->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan {{ $prescriptions->firstItem() ?? 0 }} - {{ $prescriptions->lastItem() ?? 0 }} dari {{ $prescriptions->total() }} data
        </div>
        {{ $prescriptions->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
