@extends('layouts.admin')

@section('title', 'Detail Konsultasi')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Detail Konsultasi</h1><p class="page-subtitle">{{ $consultation->patient->name }}</p></div>
    <a href="{{ route('dokter.konsultasi.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="section-card animate-fade-in">
            <div class="section-title"><i class="fas fa-user text-primary"></i>Data Pasien</div>
            <table class="table table-borderless">
                <tr><td>Nama</td><td><strong>{{ $consultation->patient->name }}</strong></td></tr>
                <tr><td>Email</td><td>{{ $consultation->patient->email }}</td></tr>
                <tr><td>Telepon</td><td>{{ $consultation->patient->phone ?? '-' }}</td></tr>
            </table>
        </div>
    </div>
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <div class="section-title"><i class="fas fa-stethoscope text-success"></i>Pemeriksaan</div>
            <form action="{{ route('dokter.konsultasi.update', $consultation->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Anamnesis</label>
                        <textarea name="anamnesis" class="form-control" rows="3">{{ $consultation->anamnesis }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Diagnosa</label>
                        <textarea name="diagnosa" class="form-control" rows="3">{{ $consultation->diagnosa }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Rencana Terapi</label>
                        <textarea name="rencana_terapi" class="form-control" rows="2">{{ $consultation->rencana_terapi }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
