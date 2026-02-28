@extends('layouts.admin')

@section('title', 'Riwayat Medis: ' . $patient->name)

@section('content')
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Riwayat Medis</h1>
        <p class="page-subtitle">{{ $patient->name }}</p>
    </div>
    <a href="{{ route('admin.riwayat-medis.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="section-card animate-fade-in">
            <div class="section-title"><i class="fas fa-user text-primary"></i>Informasi Pasien</div>
            <table class="table table-borderless">
                <tr><td>Nama</td><td><strong>{{ $patient->name }}</strong></td></tr>
                <tr><td>Email</td><td>{{ $patient->email }}</td></tr>
                <tr><td>Telepon</td><td>{{ $patient->phone ?? '-' }}</td></tr>
                <tr><td>Tgl Lahir</td><td>{{ $patient->profile->tanggal_lahir ?? '-' }}</td></tr>
            </table>
        </div>
    </div>
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <div class="section-title"><i class="fas fa-heartbeat text-danger"></i>Kondisi Kronis</div>
            @if($patient->chronicConditions->count() > 0)
                <div class="d-flex flex-wrap gap-2">
                    @foreach($patient->chronicConditions as $condition)
                        <span class="chronic-badge" style="background: {{ $condition->chronicCategory->warna }}20; color: {{ $condition->chronicCategory->warna }};">
                            <i class="fas {{ $condition->chronicCategory->icon }}"></i>
                            {{ $condition->chronicCategory->nama }}
                        </span>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Tidak ada kondisi kronis</p>
            @endif
        </div>
    </div>
</div>

<div class="section-card animate-fade-in">
    <div class="section-title"><i class="fas fa-calendar-check text-success"></i>Riwayat Konsultasi</div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Tanggal</th><th>Dokter</th><th>Diagnosa</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($consultations as $c)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($c->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $c->doctor->name }}</td>
                    <td>{{ Str::limit($c->diagnosa, 50) ?? '-' }}</td>
                    <td><span class="badge badge-completed">{{ $c->status }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Tidak ada konsultasi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($consultations->hasPages())<div class="pagination-container">{{ $consultations->links('pagination.bootstrap-5') }}</div>@endif
</div>

<div class="section-card animate-fade-in mt-4">
    <div class="section-title"><i class="fas fa-prescription text-warning"></i>Riwayat Resep</div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Tanggal</th><th>Dokter</th><th>Obat</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($prescriptions as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_resep)->format('d/m/Y') }}</td>
                    <td>{{ $p->doctor->name }}</td>
                    <td>{{ $p->prescriptionItems->count() }} obat</td>
                    <td><span class="badge badge-confirmed">{{ $p->status }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Tidak ada resep</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
