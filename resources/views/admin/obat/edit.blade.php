@extends('layouts.admin')
@section('title', 'Edit Obat')

@section('content')
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Edit Obat</h1>
        <p class="page-subtitle">Ubah data obat</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <form action="{{ route('admin.obat.update', $medicine->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Kode Obat</label>
                    <input type="text" name="kode" class="form-control" value="{{ $medicine->kode }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="nama" class="form-control" value="{{ $medicine->nama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Generik</label>
                    <input type="text" name="nama_generik" class="form-control" value="{{ $medicine->nama_generik }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ $medicine->kategori }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Satuan</label>
                    <select name="satuan" class="form-select" required>
                        <option value="tablet" {{ $medicine->satuan == 'tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="kapsul" {{ $medicine->satuan == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                        <option value="botol" {{ $medicine->satuan == 'botol' ? 'selected' : '' }}>Botol</option>
                        <option value="tube" {{ $medicine->satuan == 'tube' ? 'selected' : '' }}>Tube</option>
                        <option value="ampul" {{ $medicine->satuan == 'ampul' ? 'selected' : '' }}>Ampul</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ $medicine->deskripsi }}</textarea>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $medicine->is_active ? 'checked' : '' }}>
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
