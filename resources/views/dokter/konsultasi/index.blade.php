@extends('layouts.admin')

@section('title', 'Daftar Konsultasi')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Daftar Konsultasi</h1><p class="page-subtitle">Semua konsultasi pasien</p></div>
</div>

<div class="section-card animate-fade-in">
    <form action="{{ route('dokter.konsultasi.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="section-card animate-fade-in">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Tanggal</th><th>Pasien</th><th>Keluhan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($consultations as $consultation)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($consultation->tanggal)->format('d/m/Y') }}</td>
                    <td><div class="d-flex align-items-center"><div class="avatar avatar-sm avatar-primary me-2">{{ substr($consultation->patient->name, 0, 1) }}</div>{{ $consultation->patient->name }}</div></td>
                    <td>{{ Str::limit($consultation->anamnesis, 30) ?? '-' }}</td>
                    <td>
                        @if($consultation->status == 'completed')
                            <span class="badge badge-completed">Selesai</span>
                        @elseif($consultation->status == 'ongoing')
                            <span class="badge badge-pending">Ongoing</span>
                        @else
                            <span class="badge badge-cancelled">{{ $consultation->status }}</span>
                        @endif
                    </td>
                    <td><a href="{{ route('dokter.konsultasi.show', $consultation->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="empty-state"><i class="fas fa-clipboard-list"></i><h5>Tidak Ada Data</h5></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($consultations->hasPages())<div class="pagination-container">{{ $consultations->links('pagination.bootstrap-5') }}</div>@endif
</div>
@endsection
