@extends('layouts.admin')

@section('title', 'Riwayat Medis')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Riwayat Medis</h1><p class="page-subtitle">Rekam medis semua pasien</p></div>
</div>

<div class="section-card animate-fade-in">
    <form action="{{ route('admin.riwayat-medis.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-8">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari pasien..." value="{{ $search }}">
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.riwayat-medis.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>
</div>

<div class="section-card animate-fade-in">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr><th>No</th><th>Nama</th><th>Email</th><th>Konsultasi</th><th>Resep</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><div class="d-flex align-items-center"><div class="avatar avatar-sm avatar-primary me-2">{{ substr($patient->name, 0, 1) }}</div>{{ $patient->name }}</div></td>
                    <td>{{ $patient->email }}</td>
                    <td><span class="badge badge-completed">{{ $patient->consultations_as_patient_count }}</span></td>
                    <td><span class="badge badge-confirmed">{{ $patient->prescriptions_as_patient_count }}</span></td>
                    <td><a href="{{ route('admin.riwayat-medis.show', $patient->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><i class="fas fa-file-medical"></i><h5>Tidak Ada Data</h5></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($patients->hasPages())<div class="pagination-container">{{ $patients->links('pagination.bootstrap-5') }}</div>@endif
</div>
@endsection
