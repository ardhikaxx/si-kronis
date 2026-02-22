@extends('layouts.admin')
@section('title', 'Edit Obat')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h4 class="mb-3">Edit Obat</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.obat.update', $medicine->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Kode Obat <span class="text-danger">*</span></label>
                            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $medicine->kode) }}" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $medicine->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Generik</label>
                            <input type="text" name="nama_generik" class="form-control @error('nama_generik') is-invalid @enderror" value="{{ old('nama_generik', $medicine->nama_generik) }}">
                            @error('nama_generik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $medicine->kategori) }}">
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <select name="satuan" class="form-select @error('satuan') is-invalid @enderror" required>
                                <option value="">Pilih Satuan</option>
                                <option value="tablet" {{ old('satuan', $medicine->satuan) == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                <option value="kapsul" {{ old('satuan', $medicine->satuan) == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                                <option value="botol" {{ old('satuan', $medicine->satuan) == 'botol' ? 'selected' : '' }}>Botol</option>
                                <option value="tube" {{ old('satuan', $medicine->satuan) == 'tube' ? 'selected' : '' }}>Tube</option>
                                <option value="ampul" {{ old('satuan', $medicine->satuan) == 'ampul' ? 'selected' : '' }}>Ampul</option>
                                <option value="vial" {{ old('satuan', $medicine->satuan) == 'vial' ? 'selected' : '' }}>Vial</option>
                            </select>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $medicine->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kontraindikasi</label>
                            <textarea name="kontraindikasi" class="form-control @error('kontraindikasi') is-invalid @enderror" rows="3">{{ old('kontraindikasi', $medicine->kontraindikasi) }}</textarea>
                            @error('kontraindikasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Efek Samping</label>
                            <textarea name="efek_samping" class="form-control @error('efek_samping') is-invalid @enderror" rows="3">{{ old('efek_samping', $medicine->efek_samping) }}</textarea>
                            @error('efek_samping')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $medicine->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update
                            </button>
                            <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
