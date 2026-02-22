@extends('layouts.admin')

@section('title', 'Detail Konsultasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Konsultasi</h1>
        <a href="{{ route('dokter.konsultasi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Data Pasien -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Data Pasien</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td width="40%"><strong>Nama</strong></td>
                            <td>{{ $booking->patient->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>NIK</strong></td>
                            <td>{{ $booking->patient->profile->nik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Lahir</strong></td>
                            <td>{{ $booking->patient->profile->tanggal_lahir ? $booking->patient->profile->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>{{ $booking->patient->profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Golongan Darah</strong></td>
                            <td>{{ $booking->patient->profile->golongan_darah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. BPJS</strong></td>
                            <td>{{ $booking->patient->profile->bpjs_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Telepon</strong></td>
                            <td>{{ $booking->patient->phone }}</td>
                        </tr>
                    </table>

                    @if($booking->patient->chronicConditions->count() > 0)
                    <div class="mt-3">
                        <strong>Penyakit Kronis:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($booking->patient->chronicConditions as $condition)
                            <li>{{ $condition->chronicCategory->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Data Booking -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-check"></i> Data Booking</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td width="40%"><strong>No. Booking</strong></td>
                                    <td>{{ $booking->booking_code }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jam</strong></td>
                                    <td>{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="badge bg-info">Dikonfirmasi</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($booking->status == 'cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td width="40%"><strong>Kategori</strong></td>
                                    <td>{{ $booking->chronicCategory->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Keluhan</strong></td>
                                    <td>{{ $booking->keluhan }}</td>
                                </tr>
                                @if($booking->catatan)
                                <tr>
                                    <td><strong>Catatan</strong></td>
                                    <td>{{ $booking->catatan }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Konsultasi -->
    @if($booking->status != 'completed' && $booking->status != 'cancelled')
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-stethoscope"></i> Form Konsultasi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dokter.konsultasi.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Anamnesis <span class="text-danger">*</span></label>
                        <textarea name="anamnesis" class="form-control @error('anamnesis') is-invalid @enderror" rows="3" required>{{ old('anamnesis', $booking->consultation->anamnesis ?? '') }}</textarea>
                        @error('anamnesis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Pemeriksaan Fisik</label>
                        <textarea name="pemeriksaan_fisik" class="form-control @error('pemeriksaan_fisik') is-invalid @enderror" rows="3">{{ old('pemeriksaan_fisik', $booking->consultation->pemeriksaan_fisik ?? '') }}</textarea>
                        @error('pemeriksaan_fisik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tekanan Darah</label>
                        <input type="text" name="tekanan_darah" class="form-control @error('tekanan_darah') is-invalid @enderror" placeholder="120/80" value="{{ old('tekanan_darah', $booking->consultation->tekanan_darah ?? '') }}">
                        @error('tekanan_darah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Berat Badan (kg)</label>
                        <input type="number" step="0.1" name="berat_badan" class="form-control @error('berat_badan') is-invalid @enderror" value="{{ old('berat_badan', $booking->consultation->berat_badan ?? '') }}">
                        @error('berat_badan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tinggi Badan (cm)</label>
                        <input type="number" step="0.1" name="tinggi_badan" class="form-control @error('tinggi_badan') is-invalid @enderror" value="{{ old('tinggi_badan', $booking->consultation->tinggi_badan ?? '') }}">
                        @error('tinggi_badan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Suhu Tubuh (°C)</label>
                        <input type="number" step="0.1" name="suhu_tubuh" class="form-control @error('suhu_tubuh') is-invalid @enderror" value="{{ old('suhu_tubuh', $booking->consultation->suhu_tubuh ?? '') }}">
                        @error('suhu_tubuh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Saturasi O2 (%)</label>
                        <input type="number" name="saturasi_o2" class="form-control @error('saturasi_o2') is-invalid @enderror" min="0" max="100" value="{{ old('saturasi_o2', $booking->consultation->saturasi_o2 ?? '') }}">
                        @error('saturasi_o2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gula Darah (mg/dL)</label>
                        <input type="number" step="0.1" name="gula_darah" class="form-control @error('gula_darah') is-invalid @enderror" value="{{ old('gula_darah', $booking->consultation->gula_darah ?? '') }}">
                        @error('gula_darah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Diagnosa <span class="text-danger">*</span></label>
                        <input type="text" name="diagnosa" class="form-control @error('diagnosa') is-invalid @enderror" required value="{{ old('diagnosa', $booking->consultation->diagnosa ?? '') }}">
                        @error('diagnosa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode ICD</label>
                        <input type="text" name="icd_code" class="form-control @error('icd_code') is-invalid @enderror" value="{{ old('icd_code', $booking->consultation->icd_code ?? '') }}">
                        @error('icd_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Rencana Terapi</label>
                        <textarea name="rencana_terapi" class="form-control @error('rencana_terapi') is-invalid @enderror" rows="2">{{ old('rencana_terapi', $booking->consultation->rencana_terapi ?? '') }}</textarea>
                        @error('rencana_terapi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Saran Dokter</label>
                        <textarea name="saran_dokter" class="form-control @error('saran_dokter') is-invalid @enderror" rows="2">{{ old('saran_dokter', $booking->consultation->saran_dokter ?? '') }}</textarea>
                        @error('saran_dokter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tindak Lanjut <span class="text-danger">*</span></label>
                        <select name="tindak_lanjut" class="form-select @error('tindak_lanjut') is-invalid @enderror" required>
                            <option value="none" {{ old('tindak_lanjut', $booking->consultation->tindak_lanjut ?? '') == 'none' ? 'selected' : '' }}>Tidak Ada</option>
                            <option value="kontrol" {{ old('tindak_lanjut', $booking->consultation->tindak_lanjut ?? '') == 'kontrol' ? 'selected' : '' }}>Kontrol Ulang</option>
                            <option value="rujukan" {{ old('tindak_lanjut', $booking->consultation->tindak_lanjut ?? '') == 'rujukan' ? 'selected' : '' }}>Rujukan</option>
                            <option value="rawat_inap" {{ old('tindak_lanjut', $booking->consultation->tindak_lanjut ?? '') == 'rawat_inap' ? 'selected' : '' }}>Rawat Inap</option>
                        </select>
                        @error('tindak_lanjut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kontrol</label>
                        <input type="date" name="tanggal_kontrol" class="form-control @error('tanggal_kontrol') is-invalid @enderror" value="{{ old('tanggal_kontrol', $booking->consultation->tanggal_kontrol ?? '') }}">
                        @error('tanggal_kontrol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dokter.konsultasi.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Konsultasi
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Data Konsultasi (jika sudah selesai) -->
    @if($booking->consultation)
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-file-medical"></i> Hasil Konsultasi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary">Anamnesis</h6>
                    <p>{{ $booking->consultation->anamnesis }}</p>

                    @if($booking->consultation->pemeriksaan_fisik)
                    <h6 class="text-primary mt-3">Pemeriksaan Fisik</h6>
                    <p>{{ $booking->consultation->pemeriksaan_fisik }}</p>
                    @endif

                    <h6 class="text-primary mt-3">Tanda Vital</h6>
                    <table class="table table-sm">
                        @if($booking->consultation->tekanan_darah)
                        <tr>
                            <td width="40%">Tekanan Darah</td>
                            <td>{{ $booking->consultation->tekanan_darah }} mmHg</td>
                        </tr>
                        @endif
                        @if($booking->consultation->berat_badan)
                        <tr>
                            <td>Berat Badan</td>
                            <td>{{ $booking->consultation->berat_badan }} kg</td>
                        </tr>
                        @endif
                        @if($booking->consultation->tinggi_badan)
                        <tr>
                            <td>Tinggi Badan</td>
                            <td>{{ $booking->consultation->tinggi_badan }} cm</td>
                        </tr>
                        @endif
                        @if($booking->consultation->suhu_tubuh)
                        <tr>
                            <td>Suhu Tubuh</td>
                            <td>{{ $booking->consultation->suhu_tubuh }} °C</td>
                        </tr>
                        @endif
                        @if($booking->consultation->saturasi_o2)
                        <tr>
                            <td>Saturasi O2</td>
                            <td>{{ $booking->consultation->saturasi_o2 }}%</td>
                        </tr>
                        @endif
                        @if($booking->consultation->gula_darah)
                        <tr>
                            <td>Gula Darah</td>
                            <td>{{ $booking->consultation->gula_darah }} mg/dL</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary">Diagnosa</h6>
                    <p>{{ $booking->consultation->diagnosa }}
                        @if($booking->consultation->icd_code)
                        <span class="badge bg-info">{{ $booking->consultation->icd_code }}</span>
                        @endif
                    </p>

                    @if($booking->consultation->rencana_terapi)
                    <h6 class="text-primary mt-3">Rencana Terapi</h6>
                    <p>{{ $booking->consultation->rencana_terapi }}</p>
                    @endif

                    @if($booking->consultation->saran_dokter)
                    <h6 class="text-primary mt-3">Saran Dokter</h6>
                    <p>{{ $booking->consultation->saran_dokter }}</p>
                    @endif

                    <h6 class="text-primary mt-3">Tindak Lanjut</h6>
                    <p>
                        @if($booking->consultation->tindak_lanjut == 'none')
                            Tidak Ada
                        @elseif($booking->consultation->tindak_lanjut == 'kontrol')
                            Kontrol Ulang
                            @if($booking->consultation->tanggal_kontrol)
                            <br><small class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($booking->consultation->tanggal_kontrol)->format('d/m/Y') }}</small>
                            @endif
                        @elseif($booking->consultation->tindak_lanjut == 'rujukan')
                            Rujukan
                        @elseif($booking->consultation->tindak_lanjut == 'rawat_inap')
                            Rawat Inap
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Resep (jika ada) -->
    @if($booking->consultation->prescription)
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-pills"></i> Resep Obat</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Dosis</th>
                        <th>Frekuensi</th>
                        <th>Durasi</th>
                        <th>Jumlah</th>
                        <th>Instruksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->consultation->prescription->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->medicine->name }}</td>
                        <td>{{ $item->dosage }}</td>
                        <td>{{ $item->frequency }}</td>
                        <td>{{ $item->duration }}</td>
                        <td>{{ $item->quantity }} {{ $item->medicine->unit }}</td>
                        <td>{{ $item->instructions ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-pills"></i> Resep Obat</h5>
        </div>
        <div class="card-body text-center">
            <p class="mb-3">Belum ada resep untuk konsultasi ini</p>
            @if($booking->status == 'completed' && $booking->consultation)
            <a href="{{ route('dokter.resep.create', ['consultation_id' => $booking->consultation->id]) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Resep
            </a>
            @endif
        </div>
    </div>
    @endif
    @endif

    <!-- Hasil Lab (jika ada) -->
    @if($booking->labResults->count() > 0)
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-flask"></i> Hasil Laboratorium</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Pemeriksaan</th>
                        <th>Hasil</th>
                        <th>Nilai Normal</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->labResults as $lab)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($lab->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $lab->jenis_pemeriksaan }}</td>
                        <td>{{ $lab->hasil }} {{ $lab->satuan }}</td>
                        <td>{{ $lab->nilai_normal }}</td>
                        <td>
                            @if($lab->status == 'normal')
                                <span class="badge bg-success">Normal</span>
                            @elseif($lab->status == 'abnormal')
                                <span class="badge bg-danger">Abnormal</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>{{ $lab->catatan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
