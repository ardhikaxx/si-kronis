@extends('layouts.admin')

@section('title', 'Detail Resep')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Detail Resep</h1><p class="page-subtitle">{{ $prescription->patient->name }}</p></div>
    <a href="{{ route('dokter.resep.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="section-card animate-fade-in">
            <div class="section-title"><i class="fas fa-user text-primary"></i>Data Pasien</div>
            <table class="table table-borderless">
                <tr><td>Nama</td><td><strong>{{ $prescription->patient->name }}</strong></td></tr>
                <tr><td>Email</td><td>{{ $prescription->patient->email }}</td></tr>
            </table>
        </div>
    </div>
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <div class="section-title"><i class="fas fa-pills text-success"></i>Daftar Obat</div>
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
</div>
@endsection
