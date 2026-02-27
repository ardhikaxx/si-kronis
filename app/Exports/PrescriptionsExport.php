<?php

namespace App\Exports;

use App\Models\Prescription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrescriptionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Prescription::with(['patient', 'doctor'])
            ->get()
            ->map(function ($prescription) {
                return [
                    'Tanggal' => $prescription->tanggal_resep->format('Y-m-d'),
                    'Kode Resep' => $prescription->kode_resep,
                    'Pasien' => $prescription->patient->name ?? '-',
                    'Dokter' => $prescription->doctor->name ?? '-',
                    'Jumlah Obat' => $prescription->items->count(),
                    'Catatan' => $prescription->catatan_umum,
                    'Status' => $prescription->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kode Resep',
            'Pasien',
            'Dokter',
            'Jumlah Obat',
            'Catatan',
            'Status',
        ];
    }
}
