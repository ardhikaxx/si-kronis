@extends('layouts.admin')
@section('title', 'Tambah Obat')

@section('content')
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Tambah Obat</h1>
        <p class="page-subtitle">Tambah obat baru ke sistem</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <form action="{{ route('admin.obat.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Kode Obat</label>
                    <input type="text" name="kode" class="form-control" value="{{ old('kode') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Generik</label>
                    <input type="text" name="nama_generik" class="form-control" value="{{ old('nama_generik') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Satuan</label>
                    <select name="satuan" class="form-select" required>
                        <option value="">Pilih Satuan</option>
                        <option value="tablet">Tablet</option>
                        <option value="kapsul">Kapsul</option>
                        <option value="botol">Botol</option>
                        <option value="tube">Tube</option>
                        <option value="ampul">Ampul</option>
                        <option value="vial">Vial</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label">Status Aktif</label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.obat.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
