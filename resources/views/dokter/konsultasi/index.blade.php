@extends('layouts.admin')

@section('title', 'Daftar Konsultasi')

@section('content')
<h1 class="page-title">Daftar Konsultasi</h1>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('dokter.konsultasi.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
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
                        <th>Pasien</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td><strong>{{ $booking->kode_booking }}</strong></td>
                        <td>{{ $booking->patient->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d M Y') }}</td>
                        <td>{{ substr($booking->jam_mulai, 0, 5) }}</td>
                        <td>{{ Str::limit($booking->keluhan, 50) }}</td>
                        <td><span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                        <td>
                            <a href="{{ route('dokter.konsultasi.show', $booking->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data konsultasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan {{ $bookings->firstItem() ?? 0 }} - {{ $bookings->lastItem() ?? 0 }} dari {{ $bookings->total() }} data
            </div>
            {{ $bookings->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
