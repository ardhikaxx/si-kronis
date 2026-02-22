@extends('layouts.admin')

@section('title', 'Data Dokter')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Data Dokter</h1>
    <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Dokter
    </a>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.dokter.index') }}" method="GET" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau spesialisasi..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.dokter.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body">
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
                        <td>{{ $doctor->name }}</td>
                        <td>{{ $doctor->email }}</td>
                        <td>{{ $doctor->doctorProfile->spesialisasi ?? '-' }}</td>
                        <td>{{ $doctor->doctorProfile->pengalaman_tahun ?? 0 }} tahun</td>
                        <td>Rp {{ number_format($doctor->doctorProfile->biaya_konsultasi ?? 0, 0, ',', '.') }}</td>
                        <td>
                            @if($doctor->doctorProfile && $doctor->doctorProfile->is_available)
                                <span class="badge bg-success">Tersedia</span>
                            @else
                                <span class="badge bg-danger">Tidak Tersedia</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.dokter.edit', $doctor->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.dokter.destroy', $doctor->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus dokter ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data dokter</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection
