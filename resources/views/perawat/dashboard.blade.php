@extends('layouts.admin')
@section('title', 'Perawat Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h4 class="mb-3">Dashboard Perawat</h4>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['pending_bookings'] }}</h3>
                            <small class="text-muted">Booking Pending</small>
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
                            <i class="fas fa-calendar-day text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['today_appointments'] }}</h3>
                            <small class="text-muted">Jadwal Hari Ini</small>
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
                            <i class="fas fa-flask text-info" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['pending_lab_results'] }}</h3>
                            <small class="text-muted">Lab Pending</small>
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
                            <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['completed_today'] }}</h3>
                            <small class="text-muted">Selesai Hari Ini</small>
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
                    <h6 class="mb-0">Booking 7 Hari Terakhir</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px; position: relative;">
                        <canvas id="bookingWeekChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Status Booking Minggu Ini</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px; position: relative;">
                        <canvas id="weeklyStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Booking Pending</h6>
                    <a href="{{ route('perawat.booking.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @forelse($pendingBookings as $booking)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="flex-shrink-0">
                            <div class="bg-warning text-white rounded p-2 text-center" style="min-width: 60px;">
                                <div style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d/m') }}</div>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $booking->patient->name }}</h6>
                            <small class="text-muted">Dokter: {{ $booking->doctor->name }}</small>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center mb-0">Tidak ada booking pending</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Jadwal Hari Ini</h6>
                </div>
                <div class="card-body">
                    @forelse($todayAppointments as $appointment)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded p-2 text-center" style="min-width: 60px;">
                                <div style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($appointment->jam_mulai)->format('H:i') }}</div>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $appointment->patient->name }}</h6>
                            <small class="text-muted">Dokter: {{ $appointment->doctor->name }}</small>
                        </div>
                        <div class="flex-shrink-0">
                            @if($appointment->status == 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @else
                                <span class="badge bg-primary">Completed</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center mb-0">Tidak ada jadwal hari ini</p>
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
        // Booking Week Chart
        const weekCanvas = document.getElementById('bookingWeekChart');
        if (weekCanvas) {
            const existingChart = Chart.getChart(weekCanvas);
            if (existingChart) existingChart.destroy();
            
            charts.bookingWeek = new Chart(weekCanvas, {
                type: 'line',
                data: {
                    labels: @json($days),
                    datasets: [{
                        label: 'Booking',
                        data: @json($bookingsByDay),
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
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

        // Weekly Status Chart
        const statusCanvas = document.getElementById('weeklyStatusChart');
        if (statusCanvas) {
            const existingChart = Chart.getChart(statusCanvas);
            if (existingChart) existingChart.destroy();
            
            const statusData = @json($weeklyBookingByStatus);
            charts.weeklyStatus = new Chart(statusCanvas, {
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
