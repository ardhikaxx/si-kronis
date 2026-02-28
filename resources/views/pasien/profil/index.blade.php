@extends('layouts.pasien')

@section('title', 'Profil Saya')

@section('content')
<div class="p-3">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <h5 class="fw-bold mb-0">Profil Saya</h5>
    </div>

    <form action="{{ route('pasien.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <div class="mobile-card animate-fade-in">
            <div class="mobile-card-header">
                <h6 class="mobile-card-title mb-0"><i class="fas fa-user me-2 text-primary"></i>Informasi Akun</h6>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
            </div>
        </div>

        <div class="mobile-card animate-fade-in">
            <div class="mobile-card-header">
                <h6 class="mobile-card-title mb-0"><i class="fas fa-id-card me-2 text-success"></i>Data Diri</h6>
            </div>
            <div class="mb-3">
                <label class="form-label">NIK</label>
                <input type="text" name="nik" class="form-control" value="{{ $profile->nik ?? '' }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="{{ $profile->tanggal_lahir ?? '' }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select">
                    <option value="">Pilih</option>
                    <option value="L" {{ ($profile->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ ($profile->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2">{{ $profile->alamat ?? '' }}</textarea>
            </div>
        </div>

        <div class="mobile-card animate-fade-in">
            <div class="mobile-card-header">
                <h6 class="mobile-card-title mb-0"><i class="fas fa-ambulance me-2 text-danger"></i>Kontak Darurat</h6>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Kontak</label>
                <input type="text" name="emergency_contact" class="form-control" value="{{ $profile->emergency_contact ?? '' }}">
            </div>
            <div class="mb-3">
                <label class="form-label">No. Telepon</label>
                <input type="text" name="emergency_phone" class="form-control" value="{{ $profile->emergency_phone ?? '' }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="fas fa-save me-2"></i>Simpan Perubahan
        </button>
    </form>
</div>
@endsection
