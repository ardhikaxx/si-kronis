@extends('layouts.admin')

@section('title', 'Riwayat Medis: ' . $patient->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Riwayat Medis</h1>
        <p class="text-muted mb-0">{{ $patient->name }} - {{ $patient->email }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.riwayat-medis.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- Patient Info -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Pasien</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%">Nama</td>
                        <td><strong>{{ $patient->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $patient->email }}</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>{{ $patient->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>{{ $patient->profile->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>{{ $patient->profile->tanggal_lahir ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>{{ $patient->profile->jenis_kelamin === 'L' ? 'Laki-laki' : ($patient->profile->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-heart me-2"></i>Kondisi Kronis</h6>
            </div>
            <div class="card-body">
                @if($patient->chronicConditions->count() > 0)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($patient->chronicConditions as $condition)
                            <span class="badge" style="background: {{ $condition->chronicCategory->warna }}20; color: {{ $condition->chronicCategory->warna }}; font-size: 14px; padding: 8px 12px;">
                                <i class="fas {{ $condition->chronicCategory->icon }} me-1"></i>
                                {{ $condition->chronicCategory->nama }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">Tidak ada kondisi kronis</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs mb-4" id="medicalTab" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" id="consultations-tab" data-bs-toggle="tab" data-bs-target="#consultations" type="button">
            <i class="fas fa-stethoscope me-2"></i>Konsultasi ({{ $consultations->total() }})
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="prescriptions-tab" data-bs-toggle="tab" data-bs-target="#prescriptions" type="button">
            <i class="fas fa-prescription me-2"></i>Resep ({{ $prescriptions->total() }})
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="labs-tab" data-bs-toggle="tab" data-bs-target="#labs" type="button">
            <i class="fas fa-flask me-2"></i>Hasil Lab ({{ $labResults->total() }})
        </button>
    </li>
</ul>

<div class="tab-content" id="medicalTabContent">
    <!-- Consultations -->
    <div class="tab-pane fade show active" id="consultations">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @forelse($consultations as $consultation)
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-1">{{ $consultation->doctor->name }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $consultation->tanggal->format('d M Y') }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $consultation->status === 'completed' ? 'success' : 'warning' }}">
                            {{ ucfirst($consultation->status) }}
                        </span>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <small class="text-muted">Keluhan</small>
                            <p class="mb-1">{{ $consultation->anamnesis ?? '-' }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Diagnosa</small>
                            <p class="mb-1">{{ $consultation->diagnosa ?? '-' }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Vital Sign</small>
                            <p class="mb-0">
                                TD: {{ $consultation->tekanan_darah ?? '-' }} | 
                                BB: {{ $consultation->berat_badan ?? '-' }} kg | 
                                Gula: {{ $consultation->gula_darah ?? '-' }}
                            </p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Rencana Terapi</small>
                            <p class="mb-0">{{ $consultation->rencana_terapi ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-4">Belum ada konsultasi</p>
                @endforelse

                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan {{ $consultations->firstItem() ?? 0 }} - {{ $consultations->lastItem() ?? 0 }} dari {{ $consultations->total() }}
                    </div>
                    {{ $consultations->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Prescriptions -->
    <div class="tab-pane fade" id="prescriptions">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @forelse($prescriptions as $prescription)
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-1">Resep #{{ $prescription->kode_resep }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-user-md me-1"></i>{{ $prescription->doctor->name }} |
                                <i class="fas fa-calendar me-1"></i>{{ $prescription->tanggal_resep->format('d M Y') }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $prescription->status === 'issued' ? 'success' : 'secondary' }}">
                            {{ ucfirst($prescription->status) }}
                        </span>
                    </div>
                    
                    @if($prescription->items->count() > 0)
                    <table class="table table-sm table-bordered mt-2">
                        <thead class="table-light">
                            <tr>
                                <th>Obat</th>
                                <th>Dosis</th>
                                <th>Frekuensi</th>
                                <th>Durasi</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prescription->items as $item)
                            <tr>
                                <td>{{ $item->nama_obat }}</td>
                                <td>{{ $item->dosis }}</td>
                                <td>{{ $item->frekuensi }}</td>
                                <td>{{ $item->durasi }}</td>
                                <td>{{ $item->jumlah }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    @if($prescription->catatan_umum)
                    <small class="text-muted">Catatan: {{ $prescription->catatan_umum }}</small>
                    @endif
                </div>
                @empty
                <p class="text-muted text-center py-4">Belum ada resep</p>
                @endforelse

                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan {{ $prescriptions->firstItem() ?? 0 }} - {{ $prescriptions->lastItem() ?? 0 }} dari {{ $prescriptions->total() }}
                    </div>
                    {{ $prescriptions->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Lab Results -->
    <div class="tab-pane fade" id="labs">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @forelse($labResults as $lab)
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-1">{{ $lab->nama_pemeriksaan }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $lab->tanggal_pemeriksaan->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Hasil</small>
                            <p class="mb-1">{{ $lab->hasil }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Catatan</small>
                            <p class="mb-0">{{ $lab->catatan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-4">Belum ada hasil laboratorium</p>
                @endforelse

                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan {{ $labResults->firstItem() ?? 0 }} - {{ $labResults->lastItem() ?? 0 }} dari {{ $labResults->total() }}
                    </div>
                    {{ $labResults->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
