<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $medicines = [
            [
                'kode' => 'MED001',
                'nama' => 'Metformin 500mg',
                'nama_generik' => 'Metformin HCl',
                'kategori' => 'Antidiabetes',
                'satuan' => 'Tablet',
                'deskripsi' => 'Obat untuk menurunkan kadar gula darah pada diabetes tipe 2',
            ],
            [
                'kode' => 'MED002',
                'nama' => 'Amlodipine 5mg',
                'nama_generik' => 'Amlodipine Besylate',
                'kategori' => 'Antihipertensi',
                'satuan' => 'Tablet',
                'deskripsi' => 'Obat untuk menurunkan tekanan darah tinggi',
            ],
            [
                'kode' => 'MED003',
                'nama' => 'Simvastatin 20mg',
                'nama_generik' => 'Simvastatin',
                'kategori' => 'Antilipid',
                'satuan' => 'Tablet',
                'deskripsi' => 'Obat untuk menurunkan kolesterol',
            ],
            [
                'kode' => 'MED004',
                'nama' => 'Salbutamol Inhaler',
                'nama_generik' => 'Salbutamol Sulfate',
                'kategori' => 'Bronkodilator',
                'satuan' => 'Inhaler',
                'deskripsi' => 'Obat untuk melegakan pernapasan pada asma',
            ],
            [
                'kode' => 'MED005',
                'nama' => 'Captopril 25mg',
                'nama_generik' => 'Captopril',
                'kategori' => 'ACE Inhibitor',
                'satuan' => 'Tablet',
                'deskripsi' => 'Obat untuk hipertensi dan gagal jantung',
            ],
            [
                'kode' => 'MED006',
                'nama' => 'Glimepiride 2mg',
                'nama_generik' => 'Glimepiride',
                'kategori' => 'Antidiabetes',
                'satuan' => 'Tablet',
                'deskripsi' => 'Obat untuk diabetes tipe 2',
            ],
            [
                'kode' => 'MED007',
                'nama' => 'Aspirin 100mg',
                'nama_generik' => 'Acetylsalicylic Acid',
                'kategori' => 'Antiplatelet',
                'satuan' => 'Tablet',
                'deskripsi' => 'Obat untuk mencegah pembekuan darah',
            ],
            [
                'kode' => 'MED008',
                'nama' => 'Omeprazole 20mg',
                'nama_generik' => 'Omeprazole',
                'kategori' => 'PPI',
                'satuan' => 'Kapsul',
                'deskripsi' => 'Obat untuk mengurangi asam lambung',
            ],
            [
                'kode' => 'MED009',
                'nama' => 'Paracetamol 500mg',
                'nama_generik' => 'Paracetamol',
                'kategori' => 'Analgesik',
                'satuan' => 'Tablet',
                'deskripsi' => 'Obat pereda nyeri dan penurun demam',
            ],
            [
                'kode' => 'MED010',
                'nama' => 'Amoxicillin 500mg',
                'nama_generik' => 'Amoxicillin',
                'kategori' => 'Antibiotik',
                'satuan' => 'Kapsul',
                'deskripsi' => 'Antibiotik untuk infeksi bakteri',
            ],
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
