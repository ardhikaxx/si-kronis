@extends('layouts.admin')

@section('title', 'Data Obat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Data Obat-obatan</h1>
    <a href="{{ route('admin.obat.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Obat
    </a>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.obat.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari nama obat, kode, atau nama generik..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="kategori" class="form-control" placeholder="Kategori..." value="{{ request('kategori') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.obat.index') }}" class="btn btn-outline-secondary w-100">
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
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Nama Generik</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medicines as $medicine)
                    <tr>
                        <td><strong>{{ $medicine->kode }}</strong></td>
                        <td>{{ $medicine->nama }}</td>
                        <td>{{ $medicine->nama_generik ?? '-' }}</td>
                        <td>
                            @if($medicine->kategori)
                                <span class="badge bg-info">{{ $medicine->kategori }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $medicine->satuan }}</td>
                        <td>
                            @if($medicine->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.obat.edit', $medicine->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.obat.destroy', $medicine->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus obat ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data obat</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan {{ $medicines->firstItem() ?? 0 }} - {{ $medicines->lastItem() ?? 0 }} dari {{ $medicines->total() }} data
            </div>
            {{ $medicines->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
