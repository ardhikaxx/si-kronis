@extends('layouts.admin')
@section('title', 'Edit Dokter')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h4 class="mb-3">Edit Dokter</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.dokter.update', $doctor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <h6 class="mb-3">Informasi Akun</h6>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $doctor->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $doctor->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $doctor->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                            <div class="password-input-wrapper">
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <div class="password-input-wrapper">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation')">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3">Informasi Profesi</h6>

                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $doctor->doctorProfile->nip) }}">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. STR</label>
                            <input type="text" name="str_number" class="form-control @error('str_number') is-invalid @enderror" value="{{ old('str_number', $doctor->doctorProfile->str_number) }}">
                            @error('str_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Spesialisasi</label>
                            <input type="text" name="spesialisasi" class="form-control @error('spesialisasi') is-invalid @enderror" value="{{ old('spesialisasi', $doctor->doctorProfile->spesialisasi) }}">
                            @error('spesialisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sub Spesialisasi</label>
                            <input type="text" name="sub_spesialisasi" class="form-control @error('sub_spesialisasi') is-invalid @enderror" value="{{ old('sub_spesialisasi', $doctor->doctorProfile->sub_spesialisasi) }}">
                            @error('sub_spesialisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pendidikan</label>
                            <input type="text" name="pendidikan" class="form-control @error('pendidikan') is-invalid @enderror" value="{{ old('pendidikan', $doctor->doctorProfile->pendidikan) }}">
                            @error('pendidikan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pengalaman (Tahun)</label>
                            <input type="number" name="pengalaman_tahun" class="form-control @error('pengalaman_tahun') is-invalid @enderror" value="{{ old('pengalaman_tahun', $doctor->doctorProfile->pengalaman_tahun) }}" min="0">
                            @error('pengalaman_tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Biaya Konsultasi (Rp)</label>
                            <input type="number" name="biaya_konsultasi" class="form-control @error('biaya_konsultasi') is-invalid @enderror" value="{{ old('biaya_konsultasi', $doctor->doctorProfile->biaya_konsultasi) }}" min="0">
                            @error('biaya_konsultasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tentang</label>
                            <textarea name="tentang" class="form-control @error('tentang') is-invalid @enderror" rows="3">{{ old('tentang', $doctor->doctorProfile->tentang) }}</textarea>
                            @error('tentang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1" {{ old('is_available', $doctor->doctorProfile->is_available) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_available">
                                    Tersedia untuk Konsultasi
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update
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
