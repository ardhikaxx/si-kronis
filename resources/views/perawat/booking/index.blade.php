@extends('layouts.admin')

@section('title', 'Konfirmasi Booking')

@section('content')
<h1 class="page-title">Konfirmasi Booking</h1>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('perawat.booking.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
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
                        <th>Dokter</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td><strong>{{ $booking->kode_booking }}</strong></td>
                        <td>{{ $booking->patient->name }}</td>
                        <td>{{ $booking->doctor->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d M Y') }}</td>
                        <td>{{ substr($booking->jam_mulai, 0, 5) }}</td>
                        <td><span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                        <td>
                            @if($booking->status == 'pending')
                            <form action="{{ route('perawat.booking.confirm', $booking->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi booking ini?')">
                                    <i class="fas fa-check"></i> Konfirmasi
                                </button>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $booking->id }}">
                                <i class="fas fa-times"></i> Batalkan
                            </button>

                            <!-- Cancel Modal -->
                            <div class="modal fade" id="cancelModal{{ $booking->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('perawat.booking.cancel', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Batalkan Booking</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan Pembatalan</label>
                                                    <textarea name="alasan_batal" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-danger">Batalkan Booking</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data booking</td>
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
