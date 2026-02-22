<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\DoctorProfile;
use App\Models\NurseProfile;
use App\Models\PatientChronicCondition;
use App\Models\DoctorSchedule;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'Admin SI-KRONIS',
            'email' => 'admin@sikronis.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Dokter Users (5 dokter)
        $doctors = [
            [
                'name' => 'Dr. Ahmad Hidayat, Sp.PD',
                'email' => 'ahmad.hidayat@sikronis.com',
                'phone' => '081234567891',
                'specialization' => 'Penyakit Dalam',
                'license_number' => 'STR-001-2020',
            ],
            [
                'name' => 'Dr. Siti Nurhaliza, Sp.JP',
                'email' => 'siti.nurhaliza@sikronis.com',
                'phone' => '081234567892',
                'specialization' => 'Jantung dan Pembuluh Darah',
                'license_number' => 'STR-002-2020',
            ],
            [
                'name' => 'Dr. Budi Santoso, Sp.PD-KEMD',
                'email' => 'budi.santoso@sikronis.com',
                'phone' => '081234567893',
                'specialization' => 'Endokrin Metabolik Diabetes',
                'license_number' => 'STR-003-2020',
            ],
            [
                'name' => 'Dr. Rina Wijaya, Sp.PD',
                'email' => 'rina.wijaya@sikronis.com',
                'phone' => '081234567894',
                'specialization' => 'Penyakit Dalam',
                'license_number' => 'STR-004-2020',
            ],
            [
                'name' => 'Dr. Hendra Gunawan, Sp.JP',
                'email' => 'hendra.gunawan@sikronis.com',
                'phone' => '081234567895',
                'specialization' => 'Kardiologi',
                'license_number' => 'STR-005-2020',
            ],
        ];

        foreach ($doctors as $index => $doctorData) {
            $doctor = User::create([
                'name' => $doctorData['name'],
                'email' => $doctorData['email'],
                'password' => Hash::make('password'),
                'phone' => $doctorData['phone'],
                'is_active' => true,
            ]);
            $doctor->assignRole('dokter');

            DoctorProfile::create([
                'user_id' => $doctor->id,
                'nip' => 'DOK' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'str_number' => $doctorData['license_number'],
                'spesialisasi' => $doctorData['specialization'],
                'sub_spesialisasi' => null,
                'pendidikan' => 'Universitas Indonesia',
                'pengalaman_tahun' => rand(5, 20),
                'biaya_konsultasi' => rand(150000, 300000),
                'tentang' => 'Dokter spesialis dengan pengalaman menangani pasien penyakit kronis.',
                'is_available' => true,
            ]);

            // Create doctor schedules (Senin - Jumat)
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
            foreach ($days as $day) {
                DoctorSchedule::create([
                    'doctor_id' => $doctor->id,
                    'hari' => $day,
                    'jam_mulai' => '08:00:00',
                    'jam_selesai' => '16:00:00',
                    'kuota' => 20,
                    'is_active' => true,
                ]);
            }
        }

        // Perawat Users (3 perawat)
        $nurses = [
            ['name' => 'Ns. Dewi Lestari, S.Kep', 'email' => 'dewi.lestari@sikronis.com', 'phone' => '081234567896'],
            ['name' => 'Ns. Andi Wijaya, S.Kep', 'email' => 'andi.wijaya@sikronis.com', 'phone' => '081234567897'],
            ['name' => 'Ns. Maya Sari, S.Kep', 'email' => 'maya.sari@sikronis.com', 'phone' => '081234567898'],
        ];

        foreach ($nurses as $index => $nurseData) {
            $nurse = User::create([
                'name' => $nurseData['name'],
                'email' => $nurseData['email'],
                'password' => Hash::make('password'),
                'phone' => $nurseData['phone'],
                'is_active' => true,
            ]);
            $nurse->assignRole('perawat');

            NurseProfile::create([
                'user_id' => $nurse->id,
                'nip' => 'NRS' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'str_number' => 'SIPP-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . '-2020',
                'spesialisasi' => 'Perawat Umum',
            ]);
        }

        // Pasien Users (50 pasien dengan data lengkap)
        $firstNames = [
            'Agus', 'Budi', 'Citra', 'Dedi', 'Eka', 'Fajar', 'Gita', 'Hadi', 'Indra', 'Joko',
            'Kartika', 'Lina', 'Made', 'Nanda', 'Omar', 'Putri', 'Qori', 'Rina', 'Sari', 'Tono',
            'Umar', 'Vina', 'Wati', 'Xena', 'Yudi', 'Zahra', 'Andi', 'Bella', 'Candra', 'Dina',
            'Eko', 'Fitri', 'Gilang', 'Hana', 'Irfan', 'Jihan', 'Kiki', 'Lani', 'Mira', 'Niko',
            'Olivia', 'Pandu', 'Qonita', 'Rudi', 'Sinta', 'Tari', 'Ulfa', 'Vino', 'Winda', 'Yoga'
        ];

        $lastNames = [
            'Pratama', 'Wijaya', 'Santoso', 'Kusuma', 'Putra', 'Sari', 'Lestari', 'Hidayat', 'Rahman', 'Gunawan',
            'Setiawan', 'Permana', 'Nugroho', 'Wibowo', 'Saputra', 'Handoko', 'Susanto', 'Kurniawan', 'Hakim', 'Firmansyah'
        ];

        $cities = [
            'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Makassar', 'Palembang', 'Tangerang', 
            'Depok', 'Bekasi', 'Bogor', 'Yogyakarta', 'Malang', 'Denpasar', 'Balikpapan'
        ];

        $provinces = [
            'DKI Jakarta', 'Jawa Timur', 'Jawa Barat', 'Sumatera Utara', 'Jawa Tengah', 
            'Sulawesi Selatan', 'Sumatera Selatan', 'Banten', 'DI Yogyakarta', 'Bali', 'Kalimantan Timur'
        ];

        $bloodTypes = ['A', 'B', 'AB', 'O'];
        $genders = ['L', 'P'];
        $chronicCategories = [1, 2, 3, 4, 5]; // Diabetes, Hipertensi, Jantung, Ginjal, Asma

        for ($i = 1; $i <= 50; $i++) {
            $firstName = $firstNames[($i - 1) % count($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;
            $email = strtolower(str_replace(' ', '.', $fullName)) . $i . '@example.com';
            $gender = $genders[array_rand($genders)];
            $city = $cities[array_rand($cities)];
            $province = $provinces[array_rand($provinces)];

            $patient = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make('password'),
                'phone' => '08' . rand(1000000000, 9999999999),
                'is_active' => true,
            ]);
            $patient->assignRole('pasien');

            // Create user profile
            UserProfile::create([
                'user_id' => $patient->id,
                'nik' => '31' . rand(10000000000000, 99999999999999),
                'tanggal_lahir' => now()->subYears(rand(25, 70))->subDays(rand(1, 365)),
                'jenis_kelamin' => $gender,
                'golongan_darah' => $bloodTypes[array_rand($bloodTypes)],
                'alamat' => 'Jl. ' . $lastNames[array_rand($lastNames)] . ' No. ' . rand(1, 100),
                'kota' => $city,
                'provinsi' => $province,
                'kode_pos' => rand(10000, 99999),
                'bpjs_number' => rand(1000000000000, 9999999999999),
                'emergency_contact' => $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)],
                'emergency_phone' => '08' . rand(1000000000, 9999999999),
            ]);

            // Assign 1-3 chronic conditions randomly
            $numConditions = rand(1, 3);
            $selectedCategories = array_rand(array_flip($chronicCategories), $numConditions);
            if (!is_array($selectedCategories)) {
                $selectedCategories = [$selectedCategories];
            }

            foreach ($selectedCategories as $categoryId) {
                PatientChronicCondition::create([
                    'user_id' => $patient->id,
                    'chronic_category_id' => $categoryId,
                    'diagnosed_at' => now()->subYears(rand(1, 10))->subDays(rand(1, 365)),
                    'catatan' => 'Pasien didiagnosa dengan kondisi kronis dan memerlukan pemantauan rutin.',
                ]);
            }
        }
    }
}
