@extends('layouts.admin')

@section('title', 'Data Pasien')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Data Pasien</h1>
        <p class="page-subtitle">Kelola semua data pasien</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah User
    </a>
</div>

<!-- Filter Card -->
<div class="section-card animate-fade-in">
    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari nama, email..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search me-1"></i> Filter
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-redo me-1"></i> Reset
            </a>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="section-card animate-fade-in">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><span class="text-muted">#{{ $user->id }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm avatar-primary me-2">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="fw-bold">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            @if($role->name == 'pasien')
                                <span class="badge badge-pending">{{ ucfirst($role->name) }}</span>
                            @elseif($role->name == 'dokter')
                                <span class="badge badge-completed">{{ ucfirst($role->name) }}</span>
                            @elseif($role->name == 'perawat')
                                <span class="badge badge-confirmed">{{ ucfirst($role->name) }}</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($role->name) }}</span>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge badge-confirmed">Aktif</span>
                        @else
                            <span class="badge badge-cancelled">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn action-btn-edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn action-btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h5>Tidak Ada Data</h5>
                            <p>Belum ada user yang tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
        </div>
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
