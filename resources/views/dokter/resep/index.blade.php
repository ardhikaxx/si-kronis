@extends('layouts.admin')

@section('title', 'Resep Digital')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Resep Digital</h1>
    <a href="{{ route('dokter.resep.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Buat Resep
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode Resep</th>
                        <th>Pasien</th>
                        <th>Tanggal</th>
                        <th>Jumlah Item</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    <tr>
                        <td><strong>{{ $prescription->kode_resep }}</strong></td>
                        <td>{{ $prescription->patient->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($prescription->tanggal_resep)->format('d M Y') }}</td>
                        <td>{{ $prescription->items->count() }} item</td>
                        <td><span class="badge badge-{{ $prescription->status }}">{{ ucfirst($prescription->status) }}</span></td>
                        <td>
                            <a href="{{ route('dokter.resep.show', $prescription->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada resep</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $prescriptions->links() }}
        </div>
    </div>
</div>
@endsection
