@extends('layouts.pasien')

@section('title', 'Booking Konsultasi')

@section('content')
<div class="p-3">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <h5 class="fw-bold mb-0">Booking Konsultasi</h5>
    </div>

    <form action="{{ route('pasien.konsultasi.store') }}" method="POST">
        @csrf

        <div class="mobile-card animate-fade-in">
            <h6 class="fw-bold mb-3"><i class="fas fa-user-md me-2 text-primary"></i>Pilih Dokter</h6>
            <select name="doctor_id" class="form-select mb-3" required>
                <option value="">-- Pilih Dokter --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->doctorProfile->spesialisasi ?? 'Umum' }}</option>
                @endforeach
            </select>
        </div>

        <div class="mobile-card animate-fade-in">
            <h6 class="fw-bold mb-3"><i class="fas fa-calendar me-2 text-success"></i>Jadwal</h6>
            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal_konsultasi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jam</label>
                <input type="time" name="jam_mulai" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipe Konsultasi</label>
                <select name="tipe_konsultasi" class="form-select">
                    <option value="online">Online</option>
                    <option value="offline">Offline (Klinik)</option>
                </select>
            </div>
        </div>

        <div class="mobile-card animate-fade-in">
            <h6 class="fw-bold mb-3"><i class="fas fa-comment me-2 text-warning"></i>Keluhan</h6>
            <div class="mb-3">
                <label class="form-label">Keluhan Utama</label>
                <textarea name="keluhan" class="form-control" rows="3" placeholder="Jelaskan keluhan Anda..."></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori (Opsional)</label>
                <select name="chronic_category_id" class="form-select">
                    <option value="">-- Pilih Kategori --</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="fas fa-paper-plane me-2"></i>Kirim Booking
        </button>
    </form>
</div>
@endsection
