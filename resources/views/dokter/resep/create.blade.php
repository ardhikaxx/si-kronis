@extends('layouts.admin')

@section('title', 'Buat Resep Baru')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Buat Resep Baru</h1>
        <a href="{{ route('dokter.resep.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Ada kesalahan dalam form:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('dokter.resep.store') }}" method="POST" id="resepForm">
        @csrf

        @if($consultation)
        <input type="hidden" name="consultation_id" value="{{ $consultation->id }}">
        
        <!-- Informasi Konsultasi -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Konsultasi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Pasien:</strong> {{ $consultation->patient->name }}</p>
                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($consultation->tanggal)->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Diagnosa:</strong> {{ $consultation->diagnosa }}</p>
                        @if($consultation->icd_code)
                        <p><strong>Kode ICD:</strong> <span class="badge bg-secondary">{{ $consultation->icd_code }}</span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> Silakan pilih konsultasi terlebih dahulu
        </div>
        @endif

        <!-- Daftar Obat -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-pills"></i> Daftar Obat</h5>
            </div>
            <div class="card-body">
                <div id="obatContainer">
                    <!-- Item obat akan ditambahkan di sini -->
                </div>
                <button type="button" class="btn btn-success" onclick="tambahObat()">
                    <i class="fas fa-plus"></i> Tambah Obat
                </button>
            </div>
        </div>

        <!-- Catatan Umum -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Catatan Umum</h5>
            </div>
            <div class="card-body">
                <textarea name="catatan_umum" class="form-control" rows="3" placeholder="Catatan untuk pasien (opsional)">{{ old('catatan_umum') }}</textarea>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('dokter.resep.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary" {{ !$consultation ? 'disabled' : '' }}>
                        <i class="fas fa-save"></i> Simpan Resep
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
let obatIndex = 0;
const medicines = @json($medicines);

function tambahObat() {
    obatIndex++;
    const container = document.getElementById('obatContainer');
    const div = document.createElement('div');
    div.className = 'card mb-3';
    div.id = 'obat-' + obatIndex;
    div.innerHTML = `
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Obat #${obatIndex}</h6>
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusObat(${obatIndex})">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Obat <span class="text-danger">*</span></label>
                    <select name="items[${obatIndex}][medicine_id]" class="form-select" onchange="updateNamaObat(${obatIndex}, this)">
                        <option value="">-- Pilih Obat --</option>
                        ${medicines.map(m => `<option value="${m.id}" data-nama="${m.nama}">${m.nama} - ${m.bentuk_sediaan}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                    <input type="text" name="items[${obatIndex}][nama_obat]" class="form-control" id="nama_obat_${obatIndex}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Dosis <span class="text-danger">*</span></label>
                    <input type="text" name="items[${obatIndex}][dosis]" class="form-control" placeholder="1 tablet" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Frekuensi <span class="text-danger">*</span></label>
                    <select name="items[${obatIndex}][frekuensi]" class="form-select" required>
                        <option value="1x sehari">1x sehari</option>
                        <option value="2x sehari">2x sehari</option>
                        <option value="3x sehari">3x sehari</option>
                        <option value="4x sehari">4x sehari</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Durasi</label>
                    <select name="items[${obatIndex}][durasi]" class="form-select">
                        <option value="7 hari">7 hari</option>
                        <option value="14 hari">14 hari</option>
                        <option value="30 hari">30 hari</option>
                        <option value="1 bulan">1 bulan</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="items[${obatIndex}][jumlah]" class="form-control" min="1" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Instruksi</label>
                    <select name="items[${obatIndex}][instruksi]" class="form-select">
                        <option value="Diminum setelah makan">Diminum setelah makan</option>
                        <option value="Diminum sebelum makan">Diminum sebelum makan</option>
                        <option value="Diminum bersama makanan">Diminum bersama makanan</option>
                        <option value="Diminum saat perut kosong">Diminum saat perut kosong</option>
                        <option value="Diminum malam sebelum tidur">Diminum malam sebelum tidur</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
}

function hapusObat(index) {
    const element = document.getElementById('obat-' + index);
    if (element) {
        element.remove();
    }
}

function updateNamaObat(index, select) {
    const selectedOption = select.options[select.selectedIndex];
    const namaObat = selectedOption.getAttribute('data-nama');
    document.getElementById('nama_obat_' + index).value = namaObat || '';
}

// Tambah 1 obat default saat halaman load
document.addEventListener('DOMContentLoaded', function() {
    tambahObat();
});
</script>
@endpush
@endsection
