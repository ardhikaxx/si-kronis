@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h4 class="mb-3">Dashboard Admin</h4>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['total_patients'] }}</h3>
                            <small class="text-muted">Total Pasien</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-md text-success" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['total_doctors'] }}</h3>
                            <small class="text-muted">Total Dokter</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-check text-info" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['total_bookings'] }}</h3>
                            <small class="text-muted">Total Booking</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['completed_consultations'] }}</h3>
                            <small class="text-muted">Konsultasi Selesai</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Trend Booking & Konsultasi (6 Bulan Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px; position: relative;">
                        <canvas id="bookingTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Status Booking</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px; position: relative;">
                        <canvas id="bookingStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Booking Terbaru</h6>
                </div>
                <div class="card-body">
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
                                    <td>{{ $booking->kode_booking }}</td>
                                    <td>{{ $booking->patient->name }}</td>
                                    <td>{{ $booking->doctor->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="badge bg-primary">Completed</span>
                                        @else
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada booking</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Top 5 Kondisi Kronis</h6>
                </div>
                <div class="card-body">
                    @forelse($topChronicCategories as $item)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <i class="fas {{ $item->chronicCategory->icon ?? 'fa-circle' }}" style="color: {{ $item->chronicCategory->warna ?? '#666' }}"></i>
                            <span class="ms-2">{{ $item->chronicCategory->nama ?? 'Unknown' }}</span>
                        </div>
                        <span class="badge bg-primary">{{ $item->total }}</span>
                    </div>
                    @empty
                    <p class="text-muted text-center">Tidak ada data</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    'use strict';
    
    // Store chart instances
    let charts = {};
    
    // Destroy all existing charts
    Object.keys(charts).forEach(key => {
        if (charts[key]) {
            charts[key].destroy();
        }
    });
    charts = {};
    
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCharts);
    } else {
        initCharts();
    }
    
    function initCharts() {
        // Booking Trend Chart
        const trendCanvas = document.getElementById('bookingTrendChart');
        if (trendCanvas) {
            const existingChart = Chart.getChart(trendCanvas);
            if (existingChart) existingChart.destroy();
            
            charts.bookingTrend = new Chart(trendCanvas, {
                type: 'line',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Booking',
                        data: @json($bookingsByMonth),
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        tension: 0.4
                    }, {
                        label: 'Konsultasi',
                        data: @json($consultationsByMonth),
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Booking Status Chart
        const statusCanvas = document.getElementById('bookingStatusChart');
        if (statusCanvas) {
            const existingChart = Chart.getChart(statusCanvas);
            if (existingChart) existingChart.destroy();
            
            const statusData = @json($bookingByStatus);
            charts.bookingStatus = new Chart(statusCanvas, {
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
                        backgroundColor: [
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 99, 132)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }
    }
})();
</script>
@endpush
