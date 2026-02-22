@extends('layouts.admin')

@section('title', 'Detail Resep')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Resep</h1>
        <a href="{{ route('dokter.resep.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Informasi Resep -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-file-prescription"></i> Informasi Resep</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td width="40%"><strong>Kode Resep</strong></td>
                            <td>{{ $prescription->kode_resep }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ \Carbon\Carbon::parse($prescription->tanggal_resep)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                @if($prescription->status == 'issued')
                                    <span class="badge bg-info">Diterbitkan</span>
                                @elseif($prescription->status == 'dispensed')
                                    <span class="badge bg-success">Sudah Diambil</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($prescription->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @if($prescription->dispensed_at)
                        <tr>
                            <td><strong>Diambil Pada</strong></td>
                            <td>{{ \Carbon\Carbon::parse($prescription->dispensed_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Pasien -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Data Pasien</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td width="40%"><strong>Nama</strong></td>
                            <td>{{ $prescription->patient->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>NIK</strong></td>
                            <td>{{ $prescription->patient->profile->nik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Lahir</strong></td>
                            <td>{{ $prescription->patient->profile->tanggal_lahir ? $prescription->patient->profile->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>{{ $prescription->patient->profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Telepon</strong></td>
                            <td>{{ $prescription->patient->phone }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Konsultasi -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-stethoscope"></i> Data Konsultasi</h5>
                </div>
                <div class="card-body">
                    @if($prescription->consultation)
                    <table class="table table-sm">
                        <tr>
                            <td width="40%"><strong>Tanggal</strong></td>
                            <td>{{ \Carbon\Carbon::parse($prescription->consultation->tanggal)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diagnosa</strong></td>
                            <td>{{ $prescription->consultation->diagnosa }}</td>
                        </tr>
                        @if($prescription->consultation->icd_code)
                        <tr>
                            <td><strong>Kode ICD</strong></td>
                            <td><span class="badge bg-secondary">{{ $prescription->consultation->icd_code }}</span></td>
                        </tr>
                        @endif
                        @if($prescription->consultation->booking)
                        <tr>
                            <td><strong>No. Booking</strong></td>
                            <td>{{ $prescription->consultation->booking->kode_booking }}</td>
                        </tr>
                        @endif
                    </table>
                    @else
                    <p class="text-muted mb-0">Data konsultasi tidak tersedia</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Obat -->
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-pills"></i> Daftar Obat</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Nama Obat</th>
                            <th width="12%">Dosis</th>
                            <th width="15%">Frekuensi</th>
                            <th width="10%">Durasi</th>
                            <th width="8%">Jumlah</th>
                            <th width="25%">Instruksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescription->items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->nama_obat }}</strong>
                                @if($item->medicine)
                                <br><small class="text-muted">{{ $item->medicine->bentuk_sediaan }}</small>
                                @endif
                            </td>
                            <td>{{ $item->dosis }}</td>
                            <td>{{ $item->frekuensi }}</td>
                            <td>{{ $item->durasi ?? '-' }}</td>
                            <td class="text-center">
                                {{ $item->jumlah }}
                                @if($item->medicine)
                                {{ $item->medicine->satuan }}
                                @endif
                            </td>
                            <td>{{ $item->instruksi ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada item obat</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($prescription->catatan_umum)
            <div class="alert alert-info mt-3">
                <strong><i class="fas fa-info-circle"></i> Catatan Umum:</strong><br>
                {{ $prescription->catatan_umum }}
            </div>
            @endif
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('dokter.resep.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Cetak Resep
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header, nav, .sidebar {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection
