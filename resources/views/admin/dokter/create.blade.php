@extends('layouts.admin')
@section('title', 'Tambah Dokter')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h4 class="mb-3">Tambah Dokter Baru</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.dokter.store') }}" method="POST">
                        @csrf
                        
                        <h6 class="mb-3">Informasi Akun</h6>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation')">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3">Informasi Profesi</h6>

                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. STR</label>
                            <input type="text" name="str_number" class="form-control @error('str_number') is-invalid @enderror" value="{{ old('str_number') }}">
                            @error('str_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Spesialisasi</label>
                            <input type="text" name="spesialisasi" class="form-control @error('spesialisasi') is-invalid @enderror" value="{{ old('spesialisasi') }}">
                            @error('spesialisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sub Spesialisasi</label>
                            <input type="text" name="sub_spesialisasi" class="form-control @error('sub_spesialisasi') is-invalid @enderror" value="{{ old('sub_spesialisasi') }}">
                            @error('sub_spesialisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pendidikan</label>
                            <input type="text" name="pendidikan" class="form-control @error('pendidikan') is-invalid @enderror" value="{{ old('pendidikan') }}">
                            @error('pendidikan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pengalaman (Tahun)</label>
                            <input type="number" name="pengalaman_tahun" class="form-control @error('pengalaman_tahun') is-invalid @enderror" value="{{ old('pengalaman_tahun', 0) }}" min="0">
                            @error('pengalaman_tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Biaya Konsultasi (Rp)</label>
                            <input type="number" name="biaya_konsultasi" class="form-control @error('biaya_konsultasi') is-invalid @enderror" value="{{ old('biaya_konsultasi', 0) }}" min="0">
                            @error('biaya_konsultasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tentang</label>
                            <textarea name="tentang" class="form-control @error('tentang') is-invalid @enderror" rows="3">{{ old('tentang') }}</textarea>
                            @error('tentang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                            <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
