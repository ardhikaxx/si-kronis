@extends('layouts.admin')

@section('title', 'Jadwal Praktik')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Jadwal Praktik</h1><p class="page-subtitle">Kelola jadwal konsultasi Anda</p></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal"><i class="fas fa-plus me-2"></i>Tambah Jadwal</button>
</div>

<div class="section-card animate-fade-in">
    <div class="section-title"><i class="fas fa-calendar text-primary"></i>Jadwal Mingguan</div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Hari</th><th>Mulai</th><th>Selesai</th><th>Kuota</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr>
                    <td><span class="fw-bold">{{ $schedule->hari }}</span></td>
                    <td>{{ substr($schedule->jam_mulai, 0, 5) }}</td>
                    <td>{{ substr($schedule->jam_selesai, 0, 5) }}</td>
                    <td>{{ $schedule->kuota }}</td>
                    <td>
                        @if($schedule->is_active)
                            <span class="badge badge-confirmed">Aktif</span>
                        @else
                            <span class="badge badge-cancelled">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <button class="action-btn action-btn-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $schedule->id }}"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('dokter.jadwal.destroy', $schedule->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="action-btn action-btn-delete" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><i class="fas fa-calendar"></i><h5>Tidak Ada Jadwal</h5></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
