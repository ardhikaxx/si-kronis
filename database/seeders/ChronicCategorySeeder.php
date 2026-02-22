<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChronicCategory;
use Illuminate\Support\Str;

class ChronicCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Diabetes Melitus',
                'slug' => 'diabetes-melitus',
                'deskripsi' => 'Penyakit kronis yang ditandai dengan tingginya kadar gula darah',
                'icon' => 'fa-droplet',
                'warna' => '#f59e0b',
            ],
            [
                'nama' => 'Hipertensi',
                'slug' => 'hipertensi',
                'deskripsi' => 'Tekanan darah tinggi yang dapat menyebabkan komplikasi serius',
                'icon' => 'fa-heart-pulse',
                'warna' => '#ef4444',
            ],
            [
                'nama' => 'Penyakit Jantung',
                'slug' => 'penyakit-jantung',
                'deskripsi' => 'Gangguan pada jantung dan pembuluh darah',
                'icon' => 'fa-heart',
                'warna' => '#ec4899',
            ],
            [
                'nama' => 'Asma',
                'slug' => 'asma',
                'deskripsi' => 'Penyakit pernapasan kronis yang menyebabkan sesak napas',
                'icon' => 'fa-lungs',
                'warna' => '#06b6d4',
            ],
            [
                'nama' => 'Gagal Ginjal Kronis',
                'slug' => 'gagal-ginjal-kronis',
                'deskripsi' => 'Penurunan fungsi ginjal secara bertahap',
                'icon' => 'fa-kidneys',
                'warna' => '#8b5cf6',
            ],
            [
                'nama' => 'Stroke',
                'slug' => 'stroke',
                'deskripsi' => 'Gangguan aliran darah ke otak',
                'icon' => 'fa-brain',
                'warna' => '#f97316',
            ],
            [
                'nama' => 'Kolesterol Tinggi',
                'slug' => 'kolesterol-tinggi',
                'deskripsi' => 'Kadar lemak berlebih dalam darah',
                'icon' => 'fa-vial',
                'warna' => '#eab308',
            ],
            [
                'nama' => 'Arthritis',
                'slug' => 'arthritis',
                'deskripsi' => 'Peradangan pada sendi',
                'icon' => 'fa-bone',
                'warna' => '#14b8a6',
            ],
        ];

        foreach ($categories as $category) {
            ChronicCategory::create($category);
        }
    }
}
