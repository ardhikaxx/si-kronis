@extends('layouts.admin')
@section('title', 'Edit Dokter')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Edit Dokter</h1><p class="page-subtitle">Ubah data dokter</p></div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <form action="{{ route('admin.dokter.update', $doctor->id) }}" method="POST">
                @csrf @method('PUT')
                <h6 class="mb-3">Informasi Akun</h6>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ $doctor->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $doctor->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ $doctor->phone }}">
                </div>
                
                <h6 class="mb-3 mt-4">Profil Dokter</h6>
                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" value="{{ $doctor->doctorProfile->nip ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">STR Number</label>
                    <input type="text" name="str_number" class="form-control" value="{{ $doctor->doctorProfile->str_number ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Spesialisasi</label>
                    <input type="text" name="spesialisasi" class="form-control" value="{{ $doctor->doctorProfile->spesialisasi ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Biaya Konsultasi</label>
                    <input type="number" name="biaya_konsultasi" class="form-control" value="{{ $doctor->doctorProfile->biaya_konsultasi ?? 0 }}">
                </div>
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_available" value="1" {{ ($doctor->doctorProfile->is_available ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label">Tersedia</label>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                    <a href="{{ route('admin.dokter.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
