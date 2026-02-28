@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Laporan & Statistik</h1><p class="page-subtitle">Data statistik klinik</p></div>
    <a href="{{ route('admin.laporan.export') }}" class="btn btn-success"><i class="fas fa-download me-2"></i>Export</a>
</div>

<div class="section-card animate-fade-in">
    <form action="{{ route('admin.laporan.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="from_date" class="form-control" value="{{ $fromDate }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="to_date" class="form-control" value="{{ $toDate }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i>Tampilkan</button>
        </div>
    </form>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon avatar-primary"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-value">{{ $stats['total_bookings'] }}</div>
            <div class="stat-label">Total Booking</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon avatar-success"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value">{{ $stats['completed_bookings'] }}</div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon avatar-warning"><i class="fas fa-clock"></i></div>
            <div class="stat-value">{{ $stats['pending_bookings'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card info">
            <div class="stat-icon avatar-info"><i class="fas fa-users"></i></div>
            <div class="stat-value">{{ $stats['total_patients'] }}</div>
            <div class="stat-label">Pasien</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="section-card">
            <div class="section-title"><i class="fas fa-chart-pie text-primary"></i>Status Booking</div>
            <div style="height: 250px;">
                @if($bookingsByStatus->count() > 0)
                <canvas id="statusChart"></canvas>
                @else
                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                    <div class="text-center">
                        <i class="fas fa-chart-pie fa-3x mb-3 opacity-50"></i>
                        <p class="mb-0">Tidak ada data</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="section-card">
            <div class="section-title"><i class="fas fa-chart-bar text-success"></i>Konsultasi per Bulan</div>
            <div style="height: 250px;">
                @if($dailyBookings->count() > 0)
                <canvas id="monthlyChart"></canvas>
                @else
                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                    <div class="text-center">
                        <i class="fas fa-chart-bar fa-3x mb-3 opacity-50"></i>
                        <p class="mb-0">Tidak ada data</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Status Booking Chart
    const statusData = @json($bookingsByStatus);
    if (statusData.length > 0) {
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: statusData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1)),
                datasets: [{
                    data: statusData.map(item => item.total),
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#6b7280'],
                    borderWidth: 0
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

    // Monthly Consultations Chart
    const dailyData = @json($dailyBookings);
    if (dailyData.length > 0) {
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: dailyData.map(item => item.date),
                datasets: [{
                    label: 'Jumlah Booking',
                    data: dailyData.map(item => item.total),
                    backgroundColor: '#10b981',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
</script>
@endpush
@endsection
