@extends('layouts.admin')

@section('title', 'Data Obat')

@section('content')
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Data Obat</h1>
        <p class="page-subtitle">Kelola semua obat klinik</p>
    </div>
    <a href="{{ route('admin.obat.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Obat
    </a>
</div>

<!-- Filter -->
<div class="section-card animate-fade-in">
    <form action="{{ route('admin.obat.index') }}" method="GET" class="row g-3">
        <div class="col-md-5">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari obat..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <input type="text" name="kategori" class="form-control" placeholder="Kategori..." value="{{ request('kategori') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search me-1"></i>Filter
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.obat.index') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-redo me-1"></i>Reset
            </a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="section-card animate-fade-in">
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
                    <td><span class="fw-bold">{{ $medicine->kode }}</span></td>
                    <td>{{ $medicine->nama }}</td>
                    <td>{{ $medicine->nama_generik ?? '-' }}</td>
                    <td>
                        @if($medicine->kategori)
                            <span class="badge badge-completed">{{ $medicine->kategori }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $medicine->satuan }}</td>
                    <td>
                        @if($medicine->is_active)
                            <span class="badge badge-confirmed">Aktif</span>
                        @else
                            <span class="badge badge-cancelled">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.obat.edit', $medicine->id) }}" class="action-btn action-btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.obat.destroy', $medicine->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn action-btn-delete" onclick="return confirm('Yakin hapus?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-pills"></i>
                            <h5>Tidak Ada Data</h5>
                            <p>Belum ada obat</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($medicines->hasPages())
    <div class="pagination-container">
        {{ $medicines->links('pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
