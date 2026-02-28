@extends('layouts.admin')

@section('title', 'Data Dokter')

@section('content')
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Data Dokter</h1>
        <p class="page-subtitle">Kelola semua dokter</p>
    </div>
    <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Dokter
    </a>
</div>

<div class="section-card animate-fade-in">
    <form action="{{ route('admin.dokter.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-8">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari dokter..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search me-1"></i>Filter
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.dokter.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>
</div>

<div class="section-card animate-fade-in">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Spesialisasi</th>
                    <th>Pengalaman</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $doctor)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-primary me-2">{{ substr($doctor->name, 0, 1) }}</div>
                            {{ $doctor->name }}
                        </div>
                    </td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->doctorProfile->spesialisasi ?? '-' }}</td>
                    <td>{{ $doctor->doctorProfile->pengalaman_tahun ?? 0 }} tahun</td>
                    <td>Rp {{ number_format($doctor->doctorProfile->biaya_konsultasi ?? 0, 0, ',', '.') }}</td>
                    <td>
                        @if($doctor->doctorProfile && $doctor->doctorProfile->is_available)
                            <span class="badge badge-confirmed">Tersedia</span>
                        @else
                            <span class="badge badge-cancelled">Tidak Tersedia</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.dokter.edit', $doctor->id) }}" class="action-btn action-btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.dokter.destroy', $doctor->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn action-btn-delete" onclick="return confirm('Yakin hapus?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7"><div class="empty-state"><i class="fas fa-user-md"></i><h5>Tidak Ada Data</h5></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($doctors->hasPages())
    <div class="pagination-container">
        {{ $doctors->links('pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
