@extends('layouts.pasien')
@section('title', 'Detail Resep')

@section('content')
    <div class="mb-4 d-flex align-items-center gap-3">
        <a href="{{ route('pasien.resep.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h5 class="fw-bold mb-0">Detail Resep</h5>
    </div>

    <div class="card sk-card border-0 bg-white mb-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between mb-3">
                <span class="badge {{ $prescription->status == 'dispensed' ? 'bg-success' : 'bg-warning' }} rounded-pill px-3 py-1 text-capitalize">
                    {{ $prescription->status }}
                </span>
                <small class="text-muted fw-bold">{{ $prescription->kode_resep }}</small>
            </div>
            
            <div class="mb-3">
                <label class="text-muted d-block small mb-1">Dokter Penulis</label>
                <h6 class="fw-bold">{{ $prescription->doctor->name ?? 'Dokter' }}</h6>
            </div>
            <div class="mb-3">
                <label class="text-muted d-block small mb-1">Tanggal</label>
                <h6 class="fw-bold">{{ \Carbon\Carbon::parse($prescription->tanggal_resep)->format('d F Y') }}</h6>
            </div>

            <hr class="border-secondary opacity-10">

            <h6 class="fw-bold mb-3">Daftar Obat</h6>
            <div class="d-flex flex-column gap-3">
                @foreach($prescription->prescriptionItems as $item)
                    <div class="bg-light p-3 rounded-3">
                        <div class="d-flex justify-content-between mb-1">
                            <h6 class="fw-bold mb-0">{{ $item->nama_obat }}</h6>
                            <span class="badge bg-secondary">{{ $item->jumlah }} {{ $item->medicine->satuan ?? 'pcs' }}</span>
                        </div>
                        <p class="small text-muted mb-0">{{ $item->dosis }} - {{ $item->frekuensi }}</p>
                        @if($item->instruksi)
                            <small class="d-block mt-1 text-info fst-italic">{{ $item->instruksi }}</small>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($prescription->catatan_umum)
                <div class="mt-4 p-3 bg-light-info rounded-3 border-start border-4 border-info">
                    <small class="d-block fw-bold text-info mb-1">Catatan Tambahan:</small>
                    <p class="mb-0 small text-muted">{{ $prescription->catatan_umum }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
