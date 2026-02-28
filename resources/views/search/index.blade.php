@extends('layouts.admin')

@section('title', 'Pencarian: ' . $query)

@section('content')
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Hasil Pencarian</h1>
        <p class="page-subtitle">Kata kunci: "{{ $query }}" - {{ $totalResults }} hasil ditemukan</p>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

@if($totalResults === 0)
<div class="section-card animate-fade-in">
    <div class="text-center py-5">
        <i class="fas fa-search fa-4x text-muted mb-3"></i>
        <h5>Tidak ada hasil</h5>
        <p class="text-muted">Coba kata kunci lain</p>
    </div>
</div>
@else
{{-- Patients --}}
@if($results['patients']->count() > 0)
<div class="section-card animate-fade-in mb-4">
    <div class="section-title"><i class="fas fa-users text-primary"></i>Pasien ({{ $results['patients']->count() }})</div>
    <div class="table-responsive">
        <table class="sk-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results['patients'] as $patient)
                <tr>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone ?? '-' }}</td>
                    <td>
                        @if($role === 'admin')
                        <a href="{{ route('admin.users.show', $patient->id) }}" class="btn btn-sm btn-info">Lihat</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Doctors --}}
@if($results['doctors']->count() > 0 && $role === 'admin')
<div class="section-card animate-fade-in mb-4">
    <div class="section-title"><i class="fas fa-user-md text-success"></i>Dokter ({{ $results['doctors']->count() }})</div>
    <div class="table-responsive">
        <table class="sk-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results['doctors'] as $doctor)
                <tr>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>
                        <a href="{{ route('admin.dokter.show', $doctor->id) }}" class="btn btn-sm btn-info">Lihat</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Bookings --}}
@if($results['bookings']->count() > 0)
<div class="section-card animate-fade-in mb-4">
    <div class="section-title"><i class="fas fa-calendar-check text-warning"></i>Booking ({{ $results['bookings']->count() }})</div>
    <div class="table-responsive">
        <table class="sk-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pasien</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results['bookings'] as $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>
                    <td>{{ $booking->patient->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d/m/Y') }}</td>
                    <td>
                        @switch($booking->status)
                            @case('pending')
                                <span class="badge bg-warning">Pending</span>
                                @break
                            @case('confirmed')
                                <span class="badge bg-success">Confirmed</span>
                                @break
                            @case('completed')
                                <span class="badge bg-info">Completed</span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        @if($role === 'admin')
                        <a href="{{ route('admin.konsultasi.show', $booking->id) }}" class="btn btn-sm btn-info">Lihat</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Consultations --}}
@if($results['consultations']->count() > 0)
<div class="section-card animate-fade-in mb-4">
    <div class="section-title"><i class="fas fa-stethoscope text-info"></i>Konsultasi ({{ $results['consultations']->count() }})</div>
    <div class="table-responsive">
        <table class="sk-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Keluhan</th>
                    <th>Diagnosa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results['consultations'] as $consultation)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($consultation->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $consultation->patient->name ?? '-' }}</td>
                    <td>{{ Str::limit($consultation->anamnesis, 50) }}</td>
                    <td>{{ $consultation->diagnosa ?? '-' }}</td>
                    <td>
                        @switch($consultation->status)
                            @case('completed')
                                <span class="badge bg-success">Selesai</span>
                                @break
                            @case('in_progress')
                                <span class="badge bg-primary">Diproses</span>
                                @break
                            @default
                                <span class="badge bg-secondary">{{ $consultation->status }}</span>
                        @endswitch
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Medicines --}}
@if($results['medicines']->count() > 0 && $role === 'admin')
<div class="section-card animate-fade-in mb-4">
    <div class="section-title"><i class="fas fa-pills text-danger"></i>Obat ({{ $results['medicines']->count() }})</div>
    <div class="table-responsive">
        <table class="sk-table">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Nama Generik</th>
                    <th>Jenis</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results['medicines'] as $medicine)
                <tr>
                    <td>{{ $medicine->name }}</td>
                    <td>{{ $medicine->generic_name ?? '-' }}</td>
                    <td>{{ $medicine->type ?? '-' }}</td>
                    <td>{{ $medicine->stock ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endif
@endsection
