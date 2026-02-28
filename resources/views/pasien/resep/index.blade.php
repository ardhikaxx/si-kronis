@extends('layouts.pasien')

@section('title', 'Resep Digital')

@section('content')
<div class="p-3">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <h5 class="fw-bold mb-0">Resep Digital</h5>
        <a href="{{ route('pasien.resep.refills') }}" class="btn btn-sm btn-outline-primary">Request Refill</a>
    </div>

    @forelse($prescriptions as $prescription)
    <div class="mobile-card animate-fade-in">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <small class="text-muted">{{ $prescription->kode_resep }}</small>
                <h6 class="fw-bold mb-1">{{ $prescription->doctor->name }}</h6>
                <small class="text-muted">{{ \Carbon\Carbon::parse($prescription->tanggal_resep)->format('d M Y') }}</small>
            </div>
            @if($prescription->status == 'active')
                <span class="badge badge-confirmed">Aktif</span>
            @elseif($prescription->status == 'expired')
                <span class="badge badge-cancelled">Expired</span>
            @else
                <span class="badge badge-pending">{{ $prescription->status }}</span>
            @endif
        </div>
        <div class="mb-3">
            <small class="text-muted">{{ $prescription->prescriptionItems->count() }} item obat</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pasien.resep.show', $prescription->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                <i class="fas fa-eye me-1"></i>Lihat
            </a>
            @if($prescription->status == 'active')
            <form action="{{ route('pasien.resep.refill', $prescription->id) }}" method="POST" class="flex-grow-1">
                @csrf
                <button type="submit" class="btn btn-success btn-sm w-100">
                    <i class="fas fa-refresh me-1"></i>Refill
                </button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div class="mobile-card text-center py-5">
        <i class="fas fa-prescription text-muted" style="font-size: 64px;"></i>
        <h6 class="mt-3">Belum Ada Resep</h6>
        <p class="text-muted">Anda belum pernah mendapatkan resep</p>
    </div>
    @endforelse

    @if($prescriptions->hasPages())
    <div class="pagination-wrapper mt-4">{{ $prescriptions->links('pagination.bootstrap-5') }}</div>
    @endif
</div>
@endsection
