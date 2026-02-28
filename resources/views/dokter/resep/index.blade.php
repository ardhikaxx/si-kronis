@extends('layouts.admin')

@section('title', 'Resep Digital')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Resep Digital</h1><p class="page-subtitle">Kelola resep pasien</p></div>
    <a href="{{ route('dokter.resep.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Buat Resep</a>
</div>

<div class="section-card animate-fade-in">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Kode</th><th>Pasien</th><th>Tanggal</th><th>Item</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($prescriptions as $prescription)
                <tr>
                    <td><span class="fw-bold">{{ $prescription->kode_resep }}</span></td>
                    <td><div class="d-flex align-items-center"><div class="avatar avatar-sm avatar-primary me-2">{{ substr($prescription->patient->name, 0, 1) }}</div>{{ $prescription->patient->name }}</div></td>
                    <td>{{ \Carbon\Carbon::parse($prescription->tanggal_resep)->format('d/m/Y') }}</td>
                    <td>{{ $prescription->prescriptionItems->count() }} item</td>
                    <td>
                        @if($prescription->status == 'active')
                            <span class="badge badge-confirmed">Aktif</span>
                        @else
                            <span class="badge badge-cancelled">{{ $prescription->status }}</span>
                        @endif
                    </td>
                    <td><a href="{{ route('dokter.resep.show', $prescription->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><i class="fas fa-prescription"></i><h5>Tidak Ada Resep</h5></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($prescriptions->hasPages())<div class="pagination-container">{{ $prescriptions->links('pagination.bootstrap-5') }}</div>@endif
</div>
@endsection
