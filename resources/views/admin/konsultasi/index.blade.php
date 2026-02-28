@extends('layouts.admin')

@section('title', 'Data Konsultasi')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Data Konsultasi</h1><p class="page-subtitle">Semua booking dan konsultasi</p></div>
</div>

<div class="section-card animate-fade-in">
    <form action="{{ route('admin.konsultasi.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>
        <div class="col-md-2">
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Filter</button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
        </div>
    </form>
</div>

<div class="section-card animate-fade-in">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td><span class="fw-bold">{{ $booking->kode_booking ?? '-' }}</span></td>
                    <td><div class="d-flex align-items-center"><div class="avatar avatar-sm avatar-primary me-2">{{ substr($booking->patient->name ?? 'P', 0, 1) }}</div>{{ $booking->patient->name ?? '-' }}</div></td>
                    <td>{{ $booking->doctor->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d/m/Y') }}</td>
                    <td>
                        @if($booking->status == 'completed')
                            <span class="badge badge-completed">Selesai</span>
                        @elseif($booking->status == 'confirmed')
                            <span class="badge badge-pending">Confirmed</span>
                        @else
                            <span class="badge badge-cancelled">{{ $booking->status }}</span>
                        @endif
                    </td>
                    <td><a href="{{ route('admin.konsultasi.show', $booking->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><i class="fas fa-clipboard-list"></i><h5>Tidak Ada Data</h5></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
    <div class="pagination-container">{{ $bookings->links('pagination.bootstrap-5') }}</div>
    @endif
</div>
@endsection
