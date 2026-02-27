<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Medis - {{ $patient->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 12px;
            color: #666;
        }
        .patient-info {
            background: #f5f5f5;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .patient-info h3 {
            font-size: 13px;
            margin-bottom: 8px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .patient-info .info-row {
            display: flex;
            margin-bottom: 4px;
        }
        .patient-info .label {
            font-weight: bold;
            width: 120px;
        }
        .patient-info .value {
            flex: 1;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h2 {
            font-size: 14px;
            margin-bottom: 12px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            background: #eee;
            padding: 5px 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }
        table th {
            background: #f5f5f5;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background: #fafafa;
        }
        .consultation-item, .prescription-item, .lab-item {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .consultation-item h4, .prescription-item h4, .lab-item h4 {
            font-size: 12px;
            color: #333;
            margin-bottom: 8px;
        }
        .consultation-item .meta, .prescription-item .meta, .lab-item .meta {
            color: #666;
            font-size: 10px;
            margin-bottom: 8px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 3px;
        }
        .detail-row .label {
            font-weight: bold;
            width: 100px;
        }
        .detail-row .value {
            flex: 1;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .empty-message {
            color: #999;
            font-style: italic;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-completed { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KLINIK SI-KRONIS</h1>
            <p>Riwayat Medis Pasien</p>
        </div>

        <div class="patient-info">
            <h3>Data Pasien</h3>
            <div class="info-row">
                <span class="label">Nama:</span>
                <span class="value">{{ $patient->name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Email:</span>
                <span class="value">{{ $patient->email }}</span>
            </div>
            <div class="info-row">
                <span class="label">No. Telepon:</span>
                <span class="value">{{ $patient->phone ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tanggal Lahir:</span>
                <span class="value">{{ $patient->profile->tanggal_lahir ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Alamat:</span>
                <span class="value">{{ $patient->profile->alamat ?? '-' }}</span>
            </div>
        </div>

        <div class="section">
            <h2>Riwayat Konsultasi</h2>
            @if($consultations->count() > 0)
                @foreach($consultations as $consultation)
                    <div class="consultation-item">
                        <h4>Konsultasi #{{ $loop->iteration }}</h4>
                        <div class="meta">
                            Tanggal: {{ \Carbon\Carbon::parse($consultation->tanggal)->format('d F Y') }} | 
                            Dokter: {{ $consultation->doctor->name ?? '-' }}
                            @if($consultation->doctor->doctorProfile)
                                ({{ $consultation->doctor->doctorProfile->spesialisasi ?? '-' }})
                            @endif
                        </div>
                        <table>
                            <tr>
                                <td width="30%"><strong>Keluhan (Anamnesis)</strong></td>
                                <td>{{ $consultation->anamnesis ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Diagnosa</strong></td>
                                <td>{{ $consultation->diagnosa ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kode ICD</strong></td>
                                <td>{{ $consultation->icd_code ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Rencana Terapi</strong></td>
                                <td>{{ $consultation->rencana_terapi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Saran Dokter</strong></td>
                                <td>{{ $consultation->saran_dokter ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tindak Lanjut</strong></td>
                                <td>{{ $consultation->tindak_lanjut ?? '-' }}</td>
                            </tr>
                            @if($consultation->tekanan_darah || $consultation->berat_badan || $consultation->tinggi_badan)
                            <tr>
                                <td><strong>Pemeriksaan Fisik</strong></td>
                                <td>
                                    @if($consultation->tekanan_darah)Tekanan Darah: {{ $consultation->tekanan_darah }} mmHg<br>@endif
                                    @if($consultation->berat_badan)Berat: {{ $consultation->berat_badan }} kg<br>@endif
                                    @if($consultation->tinggi_badan)Tinggi: {{ $consultation->tinggi_badan }} cm<br>@endif
                                    @if($consultation->suhu_tubuh)Suhu: {{ $consultation->suhu_tubuh }}°C<br>@endif
                                    @if($consultation->saturasi_o2)Saturasi O2: {{ $consultation->saturasi_o2 }}%<br>@endif
                                    @if($consultation->gula_darah)Gula Darah: {{ $consultation->gula_darah }} mg/dL@endif
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>
                                    <span class="status-badge status-{{ $consultation->status }}">
                                        {{ ucfirst($consultation->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            @else
                <p class="empty-message">Belum ada riwayat konsultasi</p>
            @endif
        </div>

        <div class="section">
            <h2>Riwayat Resep</h2>
            @if($prescriptions->count() > 0)
                @foreach($prescriptions as $prescription)
                    <div class="prescription-item">
                        <h4>Resep #{{ $loop->iteration }}</h4>
                        <div class="meta">
                            Tanggal: {{ \Carbon\Carbon::parse($prescription->tanggal_resep)->format('d F Y') }} | 
                            Dokter: {{ $prescription->doctor->name ?? '-' }}
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Nama Obat</th>
                                    <th width="20%">Dosis</th>
                                    <th width="15%">Jumlah</th>
                                    <th width="30%">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prescription->prescriptionItems as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->medicine->nama ?? '-' }}</td>
                                        <td>{{ $item->dosis }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->catatan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="empty-message">Tidak ada obat</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="detail-row">
                            <span class="label">Catatan:</span>
                            <span class="value">{{ $prescription->catatan ?? '-' }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="empty-message">Belum ada riwayat resep</p>
            @endif
        </div>

        <div class="section">
            <h2>Riwayat Hasil Lab</h2>
            @if($labResults->count() > 0)
                @foreach($labResults as $lab)
                    <div class="lab-item">
                        <h4>{{ $lab->nama_lab }}</h4>
                        <div class="meta">
                            Tanggal: {{ \Carbon\Carbon::parse($lab->tanggal_lab)->format('d F Y') }}
                        </div>
                        <div class="detail-row">
                            <span class="label">File:</span>
                            <span class="value">{{ $lab->file_name }}</span>
                        </div>
                        @if($lab->catatan)
                        <div class="detail-row">
                            <span class="label">Catatan:</span>
                            <span class="value">{{ $lab->catatan }}</span>
                        </div>
                        @endif
                    </div>
                @endforeach
            @else
                <p class="empty-message">Belum ada riwayat hasil lab</p>
            @endif
        </div>

        <div class="footer">
            <p>Dokumen ini dicetak pada: {{ $tanggal_cetak }}</p>
            <p>Klinik SI-KRONIS - Sistem Informasi Rekam Medis</p>
        </div>
    </div>
</body>
</html>
