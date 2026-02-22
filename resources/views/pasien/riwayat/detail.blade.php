@extends('layouts.pasien')
@section('title', 'Detail Riwayat Konsultasi')

@section('content')
    <div class="mb-3">
        <a href="{{ route('pasien.riwayat.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <h5 class="fw-bold mb-3">Detail Konsultasi</h5>

    <!-- Informasi Dokter -->
    <div class="card sk-card mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Informasi Dokter</h6>
            <div class="mb-2">
                <small class="text-muted">Nama Dokter</small>
                <p class="mb-0">{{ $consultation->doctor->name }}</p>
            </div>
            <div class="mb-2">
                <small class="text-muted">Spesialisasi</small>
                <p class="mb-0">{{ $consultation->doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</p>
            </div>
            <div class="mb-2">
                <small class="text-muted">Tanggal Konsultasi</small>
                <p class="mb-0">{{ \Carbon\Carbon::parse($consultation->tanggal)->format('d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Keluhan Awal -->
    @if($consultation->booking)
    <div class="card sk-card mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Keluhan Awal</h6>
            <p class="mb-0">{{ $consultation->booking->keluhan }}</p>
            @if($consultation->booking->chronicCategory)
            <div class="mt-2">
                <span class="badge bg-warning">{{ $consultation->booking->chronicCategory->nama }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Anamnesis -->
    @if($consultation->anamnesis)
    <div class="card sk-card mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Anamnesis</h6>
            <p class="mb-0">{{ $consultation->anamnesis }}</p>
        </div>
    </div>
    @endif

    <!-- Pemeriksaan Fisik -->
    @if($consultation->pemeriksaan_fisik || $consultation->tekanan_darah || $consultation->berat_badan)
    <div class="card sk-card mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Pemeriksaan Fisik</h6>
            
            @if($consultation->pemeriksaan_fisik)
            <p class="mb-3">{{ $consultation->pemeriksaan_fisik }}</p>
            @endif

            <div class="row g-2">
                @if($consultation->tekanan_darah)
                <div class="col-6">
                    <small class="text-muted d-block">Tekanan Darah</small>
                    <strong>{{ $consultation->tekanan_darah }}</strong>
                </div>
                @endif
                @if($consultation->berat_badan)
                <div class="col-6">
                    <small class="text-muted d-block">Berat Badan</small>
                    <strong>{{ $consultation->berat_badan }} kg</strong>
                </div>
                @endif
                @if($consultation->tinggi_badan)
                <div class="col-6">
                    <small class="text-muted d-block">Tinggi Badan</small>
                    <strong>{{ $consultation->tinggi_badan }} cm</strong>
                </div>
                @endif
                @if($consultation->suhu_tubuh)
                <div class="col-6">
                    <small class="text-muted d-block">Suhu Tubuh</small>
                    <strong>{{ $consultation->suhu_tubuh }} °C</strong>
                </div>
                @endif
                @if($consultation->saturasi_o2)
                <div class="col-6">
                    <small class="text-muted d-block">Saturasi O2</small>
                    <strong>{{ $consultation->saturasi_o2 }}%</strong>
                </div>
                @endif
                @if($consultation->gula_darah)
                <div class="col-6">
                    <small class="text-muted d-block">Gula Darah</small>
                    <strong>{{ $consultation->gula_darah }} mg/dL</strong>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Diagnosa -->
    <div class="card sk-card mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Diagnosa</h6>
            <p class="mb-0">{{ $consultation->diagnosa }}</p>
            @if($consultation->icd_code)
            <div class="mt-2">
                <small class="text-muted">Kode ICD: {{ $consultation->icd_code }}</small>
            </div>
            @endif
        </div>
    </div>

    <!-- Rencana Terapi -->
    @if($consultation->rencana_terapi)
    <div class="card sk-card mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Rencana Terapi</h6>
            <p class="mb-0">{{ $consultation->rencana_terapi }}</p>
        </div>
    </div>
    @endif

    <!-- Saran Dokter -->
    @if($consultation->saran_dokter)
    <div class="card sk-card mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Saran Dokter</h6>
            <p class="mb-0">{{ $consultation->saran_dokter }}</p>
        </div>
    </div>
    @endif

    <!-- Tindak Lanjut -->
    @if($consultation->tindak_lanjut && $consultation->tindak_lanjut != 'none')
    <div class="card sk-card mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Tindak Lanjut</h6>
            <p class="mb-0">
                @if($consultation->tindak_lanjut == 'kontrol')
                    Kontrol Kembali
                    @if($consultation->tanggal_kontrol)
                        pada {{ \Carbon\Carbon::parse($consultation->tanggal_kontrol)->format('d F Y') }}
                    @endif
                @elseif($consultation->tindak_lanjut == 'rujukan')
                    Rujukan ke Spesialis
                @elseif($consultation->tindak_lanjut == 'rawat_inap')
                    Rawat Inap
                @endif
            </p>
        </div>
    </div>
    @endif

    <!-- Resep -->
    @if($consultation->prescription)
    <div class="card sk-card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Resep Digital</h6>
                <a href="{{ route('pasien.resep.show', $consultation->prescription->id) }}" class="btn btn-sm btn-primary">
                    Lihat Resep
                </a>
            </div>
            <small class="text-muted">{{ $consultation->prescription->prescriptionItems->count() }} item obat</small>
        </div>
    </div>
    @endif
@endsection
