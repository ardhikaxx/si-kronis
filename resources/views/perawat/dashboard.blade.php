@extends('layouts.admin')
@section('title', 'Dashboard Perawat')

@section('content')
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Dashboard Perawat</h1>
        <p class="page-subtitle">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>
    <span class="badge bg-primary py-2 px-3"><i class="fas fa-calendar me-2"></i>{{ now()->format('d F Y') }}</span>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card warning animate-fade-in animate-delay-1">
            <div class="stat-icon avatar-warning"><i class="fas fa-clock"></i></div>
            <div class="stat-value">{{ $stats['pending_bookings'] }}</div>
            <div class="stat-label">Booking Pending</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success animate-fade-in animate-delay-2">
            <div class="stat-icon avatar-success"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value">{{ $stats['today_confirmed'] }}</div>
            <div class="stat-label">Confirmed Hari Ini</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card primary animate-fade-in animate-delay-3">
            <div class="stat-icon avatar-primary"><i class="fas fa-users"></i></div>
            <div class="stat-value">{{ $stats['total_patients'] }}</div>
            <div class="stat-label">Total Pasien</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card info animate-fade-in animate-delay-4">
            <div class="stat-icon avatar-info"><i class="fas fa-flask"></i></div>
            <div class="stat-value">{{ $stats['pending_lab'] }}</div>
            <div class="stat-label">Lab Pending</div>
        </div>
    </div>
</div>

<div class="section-card animate-fade-in">
    <div class="section-title"><i class="fas fa-calendar-check text-primary"></i>Jadwal Hari Ini</div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Jam</th><th>Pasien</th><th>Dokter</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($todayBookings as $booking)
                <tr>
                    <td><span class="fw-bold">{{ substr($booking->jam_mulai, 0, 5) }}</span></td>
                    <td><div class="d-flex align-items-center"><div class="avatar avatar-sm avatar-primary me-2">{{ substr($booking->patient->name, 0, 1) }}</div>{{ $booking->patient->name }}</div></td>
                    <td>{{ $booking->doctor->name }}</td>
                    <td>{{ $booking->chronicCategory->nama ?? '-' }}</td>
                    <td>
                        @if($booking->status == 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($booking->status == 'confirmed')
                            <span class="badge badge-confirmed">Confirmed</span>
                        @else
                            <span class="badge badge-completed">{{ $booking->status }}</span>
                        @endif
                    </td>
                    <td>
                        @if($booking->status == 'pending')
                        <form action="{{ route('perawat.booking.confirm', $booking->id) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button></form>
                        <form action="{{ route('perawat.booking.cancel', $booking->id) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Batalkan?')"><i class="fas fa-times"></i></button></form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><i class="fas fa-calendar-xmark"></i><h5>Tidak Ada Jadwal</h5></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
