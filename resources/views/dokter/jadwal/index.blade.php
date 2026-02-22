@extends('layouts.admin')

@section('title', 'Jadwal Praktik')

@section('content')
<h1 class="page-title">Jadwal Praktik Saya</h1>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Jadwal Mingguan</h5>
            </div>
            <div class="card-body">
                @if($schedules->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Kuota</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            <tr>
                                <td><strong>{{ $schedule->hari }}</strong></td>
                                <td>{{ substr($schedule->jam_mulai, 0, 5) }}</td>
                                <td>{{ substr($schedule->jam_selesai, 0, 5) }}</td>
                                <td>{{ $schedule->kuota }} pasien</td>
                                <td>
                                    @if($schedule->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('dokter.jadwal.destroy', $schedule->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-muted py-4">Belum ada jadwal praktik</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Jadwal</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('dokter.jadwal.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Hari</label>
                        <select name="hari" class="form-select" required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kuota Pasien</label>
                        <input type="number" name="kuota" class="form-control" value="10" min="1" max="50" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>Tambah Jadwal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
