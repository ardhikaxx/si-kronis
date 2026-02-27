@extends('layouts.admin')

@section('title', 'Laporan & Statistik')

@section('content')
<h1 class="page-title">Laporan & Statistik</h1>

<!-- Filter Periode -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="row g-3">
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
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-2"></i>Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="sk-stat-card">
            <div class="stat-icon" style="background: #dbeafe; color: #2563eb;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-value">{{ $stats['total_bookings'] }}</div>
            <div class="stat-label">Total Booking</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="sk-stat-card">
            <div class="stat-icon" style="background: #d1fae5; color: #10b981;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $stats['completed_consultations'] }}</div>
            <div class="stat-label">Konsultasi Selesai</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="sk-stat-card">
            <div class="stat-icon" style="background: #fef3c7; color: #f59e0b;">
                <i class="fas fa-prescription"></i>
            </div>
            <div class="stat-value">{{ $stats['total_prescriptions'] }}</div>
            <div class="stat-label">Resep Diterbitkan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="sk-stat-card">
            <div class="stat-icon" style="background: #e0e7ff; color: #6366f1;">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stat-value">{{ $stats['new_patients'] }}</div>
            <div class="stat-label">Pasien Baru</div>
        </div>
    </div>
</div>

<!-- Booking by Status -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Booking Berdasarkan Status</h5>
            </div>
            <div class="card-body">
                @if($bookingsByStatus->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookingsByStatus as $item)
                            <tr>
                                <td>
                                    <span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
                                </td>
                                <td class="text-end"><strong>{{ $item->total }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-muted">Tidak ada data</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Dokter Terpopuler</h5>
            </div>
            <div class="card-body">
                @if($consultationsByDoctor->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dokter</th>
                                <th class="text-end">Konsultasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultationsByDoctor as $item)
                            <tr>
                                <td>{{ $item->doctor->name ?? 'N/A' }}</td>
                                <td class="text-end"><strong>{{ $item->total }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-muted">Tidak ada data</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Daily Bookings Chart -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Grafik Booking Harian</h5>
    </div>
    <div class="card-body">
        @if($dailyBookings->count() > 0)
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Booking</th>
                        <th>Grafik</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $maxBookings = $dailyBookings->max('total');
                    @endphp
                    @foreach($dailyBookings as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</td>
                        <td><strong>{{ $item->total }}</strong></td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-primary" role="progressbar" 
                                     style="width: {{ $maxBookings > 0 ? ($item->total / $maxBookings * 100) : 0 }}%">
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center text-muted py-4">Tidak ada data booking pada periode ini</p>
        @endif
    </div>
</div>
@endsection
