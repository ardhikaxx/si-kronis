@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->name }}!</p>
    </div>
    <div class="d-flex gap-2">
        <span class="badge bg-primary py-2 px-3">
            <i class="fas fa-calendar me-2"></i>{{ now()->format('d F Y') }}
        </span>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary animate-fade-in animate-delay-1">
            <div class="stat-icon avatar-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $stats['total_patients'] }}</div>
            <div class="stat-label">Total Pasien</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success animate-fade-in animate-delay-2">
            <div class="stat-icon avatar-success">
                <i class="fas fa-user-md"></i>
            </div>
            <div class="stat-value">{{ $stats['total_doctors'] }}</div>
            <div class="stat-label">Total Dokter</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card info animate-fade-in animate-delay-3">
            <div class="stat-icon avatar-info">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-value">{{ $stats['total_bookings'] }}</div>
            <div class="stat-label">Total Booking</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning animate-fade-in animate-delay-4">
            <div class="stat-icon avatar-warning">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $stats['completed_consultations'] }}</div>
            <div class="stat-label">Konsultasi Selesai</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <div class="section-title">
                <i class="fas fa-chart-line text-primary"></i>
                Trend Booking & Konsultasi
            </div>
            <div style="height: 300px;">
                <canvas id="bookingTrendChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="section-card animate-fade-in">
            <div class="section-title">
                <i class="fas fa-chart-pie text-success"></i>
                Status Booking
            </div>
            <div style="height: 250px;">
                <canvas id="bookingStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Data Tables -->
<div class="row g-4">
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title mb-0">
                    <i class="fas fa-clock text-warning"></i>
                    Booking Terbaru
                </div>
                <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                        <tr>
                            <td><span class="fw-bold">{{ $booking->kode_booking }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm avatar-primary me-2">
                                        {{ substr($booking->patient->name, 0, 1) }}
                                    </div>
                                    {{ $booking->patient->name }}
                                </div>
                            </td>
                            <td>{{ $booking->doctor->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d/m/Y') }}</td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge badge-confirmed">Confirmed</span>
                                @elseif($booking->status == 'completed')
                                    <span class="badge badge-completed">Completed</span>
                                @else
                                    <span class="badge badge-cancelled">Cancelled</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox d-block mb-2" style="font-size: 32px;"></i>
                                Tidak ada booking
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="section-card animate-fade-in">
            <div class="section-title">
                <i class="fas fa-heartbeat text-danger"></i>
                Top Kondisi Kronis
            </div>
            @forelse($topChronicCategories as $item)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2" style="background: {{ $item->chronicCategory->warna ?? '#666' }}20; color: {{ $item->chronicCategory->warna ?? '#666' }}">
                        <i class="fas {{ $item->chronicCategory->icon ?? 'fa-circle' }}"></i>
                    </div>
                    <span>{{ $item->chronicCategory->nama ?? 'Unknown' }}</span>
                </div>
                <span class="badge bg-primary">{{ $item->total }}</span>
            </div>
            @empty
            <p class="text-muted text-center py-4">Tidak ada data</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    'use strict';
    
    // Wait for DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCharts);
    } else {
        initCharts();
    }
    
    function initCharts() {
        // Booking Trend Chart
        const trendCanvas = document.getElementById('bookingTrendChart');
        if (trendCanvas) {
            new Chart(trendCanvas, {
                type: 'line',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Booking',
                        data: @json($bookingsByMonth),
                        borderColor: '#4F46E5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Konsultasi',
                        data: @json($consultationsByMonth),
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }

        // Booking Status Chart
        const statusCanvas = document.getElementById('bookingStatusChart');
        if (statusCanvas) {
            const statusData = @json($bookingByStatus);
            new Chart(statusCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
                    datasets: [{
                        data: [
                            statusData.pending || 0,
                            statusData.confirmed || 0,
                            statusData.completed || 0,
                            statusData.cancelled || 0
                        ],
                        backgroundColor: ['#F59E0B', '#10B981', '#4F46E5', '#EF4444']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    }
})();
</script>
@endpush
