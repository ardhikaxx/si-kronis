@extends('layouts.admin')
@section('title', 'Tambah Template Resep')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Tambah Template</h1><p class="page-subtitle">Buat template resep baru</p></div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <form action="{{ route('admin.template-resep.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Template</label>
                    <input type="text" name="nama_template" class="form-control" value="{{ old('nama_template') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label">Status Aktif</label>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                    <a href="{{ route('admin.template-resep.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
