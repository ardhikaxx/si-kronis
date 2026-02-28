@extends('layouts.admin')
@section('title', 'Dashboard Dokter')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Dashboard Dokter</h1>
        <p class="page-subtitle">Selamat datang, {{ auth()->user()->name }}!</p>
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
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-value">{{ $stats['today_appointments'] }}</div>
            <div class="stat-label">Jadwal Hari Ini</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning animate-fade-in animate-delay-2">
            <div class="stat-icon avatar-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $stats['pending_consultations'] }}</div>
            <div class="stat-label">Konsultasi Pending</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success animate-fade-in animate-delay-3">
            <div class="stat-icon avatar-success">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $stats['total_patients'] }}</div>
            <div class="stat-label">Total Pasien</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card info animate-fade-in animate-delay-4">
            <div class="stat-icon avatar-info">
                <i class="fas fa-prescription"></i>
            </div>
            <div class="stat-value">{{ $stats['prescriptions_issued'] }}</div>
            <div class="stat-label">Resep Bulan Ini</div>
        </div>
    </div>
</div>

<!-- Today's Schedule & Upcoming -->
<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <div class="section-title">
                <i class="fas fa-calendar-check text-primary"></i>
                Jadwal Hari Ini
            </div>
            @if($todaySchedule->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Jam</th>
                            <th>Pasien</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todaySchedule as $booking)
                        <tr>
                            <td><span class="fw-bold">{{ substr($booking->jam_mulai, 0, 5) }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm avatar-primary me-2">
                                        {{ substr($booking->patient->name, 0, 1) }}
                                    </div>
                                    {{ $booking->patient->name }}
                                </div>
                            </td>
                            <td>
                                @if($booking->chronicCategory)
                                <span class="chronic-badge" style="background: {{ $booking->chronicCategory->warna }}20; color: {{ $booking->chronicCategory->warna }};">
                                    {{ $booking->chronicCategory->nama }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->status == 'confirmed')
                                    <span class="badge badge-confirmed">Confirmed</span>
                                @elseif($booking->status == 'completed')
                                    <span class="badge badge-completed">Completed</span>
                                @else
                                    <span class="badge badge-pending">{{ $booking->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dokter.konsultasi.show', $booking->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-stethoscope"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state py-4">
                <i class="fas fa-calendar-xmark" style="font-size: 48px;"></i>
                <h5>Tidak Ada Jadwal</h5>
                <p>Tidak ada pasien hari ini</p>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="section-card animate-fade-in">
            <div class="section-title">
                <i class="fas fa-chart-line text-success"></i>
                Konsultasi 6 Bulan
            </div>
            <div style="height: 200px;">
                <canvas id="consultationChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Consultations -->
<div class="row g-4">
    <div class="col-md-12">
        <div class="section-card animate-fade-in">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title mb-0">
                    <i class="fas fa-history text-warning"></i>
                    Konsultasi Terbaru
                </div>
                <a href="{{ route('dokter.konsultasi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Diagnosa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentConsultations as $consultation)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($consultation->tanggal)->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm avatar-success me-2">
                                        {{ substr($consultation->patient->name, 0, 1) }}
                                    </div>
                                    {{ $consultation->patient->name }}
                                </div>
                            </td>
                            <td>{{ Str::limit($consultation->diagnosa, 40) ?? '-' }}</td>
                            <td>
                                @if($consultation->status == 'completed')
                                    <span class="badge badge-completed">Selesai</span>
                                @else
                                    <span class="badge badge-pending">{{ $consultation->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dokter.konsultasi.show', $consultation->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox d-block mb-2" style="font-size: 32px;"></i>
                                Tidak ada konsultasi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const canvas = document.getElementById('consultationChart');
    if (canvas) {
        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Konsultasi',
                    data: @json($consultationsByMonth),
                    backgroundColor: '#4F46E5',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    }
})();
</script>
@endpush
