<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrescriptionTemplate;
use App\Models\User;

class PrescriptionTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = User::whereHas('roles', function($query) {
            $query->where('name', 'dokter');
        })->get();

        if ($doctors->isEmpty()) {
            $this->command->info('Tidak ada dokter ditemukan. Seeder dilewati.');
            return;
        }

        $templates = [
            [
                'nama_template' => 'Hipertensi Ringan',
                'deskripsi' => 'Template resep untuk pasien hipertensi ringan',
                'items' => [
                    [
                        'nama_obat' => 'Amlodipine 5mg',
                        'dosis' => '5mg',
                        'frekuensi' => '1x1',
                        'durasi' => '30 hari',
                        'jumlah' => '30',
                        'instruksi' => 'Diminum pagi hari setelah makan',
                    ],
                    [
                        'nama_obat' => 'Hydrochlorothiazide 12.5mg',
                        'dosis' => '12.5mg',
                        'frekuensi' => '1x1',
                        'durasi' => '30 hari',
                        'jumlah' => '30',
                        'instruksi' => 'Diminum pagi hari',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'nama_template' => 'Diabetes Mellitus Tipe 2',
                'deskripsi' => 'Template resep untuk pasien diabetes',
                'items' => [
                    [
                        'nama_obat' => 'Metformin 500mg',
                        'dosis' => '500mg',
                        'frekuensi' => '2x1',
                        'durasi' => '30 hari',
                        'jumlah' => '60',
                        'instruksi' => 'Diminum saat makan pagi dan malam',
                    ],
                    [
                        'nama_obat' => 'Glimepiride 1mg',
                        'dosis' => '1mg',
                        'frekuensi' => '1x1',
                        'durasi' => '30 hari',
                        'jumlah' => '30',
                        'instruksi' => 'Diminum saat makan pagi',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'nama_template' => 'Asma Ringan',
                'deskripsi' => 'Template resep untuk pasien asma ringan',
                'items' => [
                    [
                        'nama_obat' => 'Salbutamol 100mcg',
                        'dosis' => '100mcg',
                        'frekuensi' => '3x1',
                        'durasi' => '30 hari',
                        'jumlah' => '1',
                        'instruksi' => '使用时吸入，每次1-2喷，需要时使用',
                    ],
                    [
                        'nama_obat' => 'Budesonide 200mcg',
                        'dosis' => '200mcg',
                        'frekuensi' => '2x1',
                        'durasi' => '30 hari',
                        'jumlah' => '1',
                        'instruksi' => '每日早晚各一次吸入',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'nama_template' => 'Batuk & Pilek',
                'deskripsi' => 'Template resep untuk gejala flu biasa',
                'items' => [
                    [
                        'nama_obat' => 'Paracetamol 500mg',
                        'dosis' => '500mg',
                        'frekuensi' => '3x1',
                        'durasi' => '5 hari',
                        'jumlah' => '15',
                        'instruksi' => 'Diminum saat demam atau sakit',
                    ],
                    [
                        'nama_obat' => 'Loratadine 10mg',
                        'dosis' => '10mg',
                        'frekuensi' => '1x1',
                        'durasi' => '7 hari',
                        'jumlah' => '7',
                        'instruksi' => 'Diminum malam hari',
                    ],
                    [
                        'nama_obat' => 'Ambroxol 30mg',
                        'dosis' => '30mg',
                        'frekuensi' => '3x1',
                        'durasi' => '5 hari',
                        'jumlah' => '15',
                        'instruksi' => 'Diminum setelah makan',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'nama_template' => 'Sakit Kepala',
                'deskripsi' => 'Template resep untuk sakit kepala',
                'items' => [
                    [
                        'nama_obat' => 'Ibuprofen 400mg',
                        'dosis' => '400mg',
                        'frekuensi' => '3x1',
                        'durasi' => '3 hari',
                        'jumlah' => '9',
                        'instruksi' => 'Diminum saat sakit kepala',
                    ],
                    [
                        'nama_obat' => 'Caffeine 50mg',
                        'dosis' => '50mg',
                        'frekuensi' => '3x1',
                        'durasi' => '3 hari',
                        'jumlah' => '9',
                        'instruksi' => 'Diminum bersama ibuprofen',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'nama_template' => 'Maag / Gastritis',
                'deskripsi' => 'Template resep untuk sakit maag',
                'items' => [
                    [
                        'nama_obat' => 'Omeprazole 20mg',
                        'dosis' => '20mg',
                        'frekuensi' => '1x1',
                        'durasi' => '14 hari',
                        'jumlah' => '14',
                        'instruksi' => 'Diminum pagi hari sebelum makan',
                    ],
                    [
                        'nama_obat' => 'Antasida Syr',
                        'dosis' => '1 sdm',
                        'frekuensi' => '3x1',
                        'durasi' => '7 hari',
                        'jumlah' => '1',
                        'instruksi' => 'Diminum 1 jam setelah makan dan saat malam sebelum tidur',
                    ],
                ],
                'is_active' => true,
            ],
        ];

        foreach ($doctors as $doctor) {
            foreach ($templates as $template) {
                PrescriptionTemplate::create([
                    'doctor_id' => $doctor->id,
                    'nama_template' => $template['nama_template'],
                    'deskripsi' => $template['deskripsi'],
                    'items' => $template['items'],
                    'is_active' => $template['is_active'],
                ]);
            }
        }

        $this->command->info('Berhasil membuat ' . (count($templates) * $doctors->count()) . ' template resep.');
    }
}
