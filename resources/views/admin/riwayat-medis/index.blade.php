@extends('layouts.admin')

@section('title', 'Riwayat Medis Pasien')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Riwayat Medis Pasien</h1>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.riwayat-medis.index') }}" method="GET" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau telepon..." value="{{ $search }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.riwayat-medis.index') }}" class="btn btn-outline-secondary w-100">
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
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Konsultasi</th>
                        <th>Resep</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td>{{ $loop->iteration + ($patients->currentPage() - 1) * $patients->perPage() }}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->phone ?? '-' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $patient->consultations_count }}x</span>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $patient->prescriptions_count }}x</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.riwayat-medis.show', $patient->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data pasien</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan {{ $patients->firstItem() ?? 0 }} - {{ $patients->lastItem() ?? 0 }} dari {{ $patients->total() }} data
            </div>
            {{ $patients->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
