@extends('layouts.pasien')

@section('title', 'Booking Konsultasi')

@section('content')
<div class="p-3">
    <h5 class="fw-bold mb-4">Booking Konsultasi</h5>

    <form action="{{ route('pasien.konsultasi.store') }}" method="POST">
        @csrf

        <div class="card sk-card mb-3">
            <div class="sk-card-header">Pilih Dokter</div>
            <div class="card-body">
                <select name="doctor_id" class="form-select" required>
                    <option value="">-- Pilih Dokter --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">
                            {{ $doctor->name }} - {{ $doctor->doctorProfile->spesialisasi ?? 'Umum' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card sk-card mb-3">
            <div class="sk-card-header">Jadwal Konsultasi</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal_konsultasi" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam</label>
                    <input type="time" name="jam_mulai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Konsultasi</label>
                    <select name="tipe_konsultasi" class="form-select" required>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card sk-card mb-3">
            <div class="sk-card-header">Informasi Keluhan</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Kategori Penyakit (Opsional)</label>
                    <select name="chronic_category_id" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($chronicCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea name="keluhan" class="form-control" rows="4" placeholder="Jelaskan keluhan Anda..." required minlength="20"></textarea>
                    <small class="text-muted">Minimal 20 karakter</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan_pasien" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="fas fa-check me-2"></i>Buat Booking
        </button>
        <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-outline-secondary w-100">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </form>
</div>
@endsection
