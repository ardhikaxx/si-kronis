<?php

namespace App\Exports;

use App\Models\Consultation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConsultationsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Consultation::with(['patient', 'doctor'])
            ->get()
            ->map(function ($consultation) {
                return [
                    'Tanggal' => $consultation->tanggal->format('Y-m-d'),
                    'Pasien' => $consultation->patient->name ?? '-',
                    'Dokter' => $consultation->doctor->name ?? '-',
                    'Keluhan' => $consultation->anamnesis,
                    'Diagnosa' => $consultation->diagnosa,
                    'Tekanan Darah' => $consultation->tekanan_darah,
                    'Berat Badan' => $consultation->berat_badan,
                    'Gula Darah' => $consultation->gula_darah,
                    'Status' => $consultation->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Pasien',
            'Dokter',
            'Keluhan',
            'Diagnosa',
            'Tekanan Darah',
            'Berat Badan',
            'Gula Darah',
            'Status',
        ];
    }
}
