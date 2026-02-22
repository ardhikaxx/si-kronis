@extends('layouts.admin')
@section('title', 'Dokter Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h4 class="mb-3">Dashboard Dokter</h4>
        </div>
    </div>

    <div class="row g-3 mb-4">
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
                            <i class="fas fa-clock text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['pending_consultations'] }}</h3>
                            <small class="text-muted">Konsultasi Pending</small>
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
                            <i class="fas fa-users text-success" style="font-size: 2rem;"></i>
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
                            <i class="fas fa-prescription text-info" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['prescriptions_issued'] }}</h3>
                            <small class="text-muted">Resep Bulan Ini</small>
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
                    <h6 class="mb-0">Trend Konsultasi (6 Bulan Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px; position: relative;">
                        <canvas id="consultationTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Konsultasi per Kategori</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px; position: relative;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Jadwal Hari Ini</h6>
                </div>
                <div class="card-body">
                    @forelse($todaySchedule as $booking)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded p-2 text-center" style="min-width: 60px;">
                                <div style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }}</div>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $booking->patient->name }}</h6>
                            <small class="text-muted">{{ $booking->keluhan }}</small>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center mb-0">Tidak ada jadwal hari ini</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Konsultasi Terbaru</h6>
                </div>
                <div class="card-body">
                    @forelse($recentConsultations as $consultation)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-circle text-secondary" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $consultation->patient->name }}</h6>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($consultation->tanggal)->format('d/m/Y') }}</small>
                        </div>
                        <div class="flex-shrink-0">
                            @if($consultation->status == 'completed')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center mb-0">Belum ada konsultasi</p>
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
        // Consultation Trend Chart
        const trendCanvas = document.getElementById('consultationTrendChart');
        if (trendCanvas) {
            const existingChart = Chart.getChart(trendCanvas);
            if (existingChart) existingChart.destroy();
            
            charts.trend = new Chart(trendCanvas, {
                type: 'bar',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Konsultasi',
                        data: @json($consultationsByMonth),
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
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

        // Category Chart
        const categoryCanvas = document.getElementById('categoryChart');
        if (categoryCanvas) {
            const existingChart = Chart.getChart(categoryCanvas);
            if (existingChart) existingChart.destroy();
            
            const categoryData = @json($consultationsByCategory);
            charts.category = new Chart(categoryCanvas, {
                type: 'pie',
                data: {
                    labels: categoryData.map(item => item.chronic_category?.nama || 'Unknown'),
                    datasets: [{
                        data: categoryData.map(item => item.total),
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)',
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
