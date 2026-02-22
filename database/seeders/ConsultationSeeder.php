<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consultation;
use App\Models\Booking;
use Carbon\Carbon;

class ConsultationSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua booking yang completed
        $completedBookings = Booking::where('status', 'completed')->get();

        if ($completedBookings->isEmpty()) {
            $this->command->warn('Tidak ada booking dengan status completed!');
            return;
        }

        $diagnoses = [
            'Diabetes Mellitus Tipe 2 terkontrol',
            'Diabetes Mellitus Tipe 2 tidak terkontrol',
            'Hipertensi Grade 1',
            'Hipertensi Grade 2',
            'Penyakit Jantung Koroner',
            'Gagal Jantung Kongestif',
            'Penyakit Ginjal Kronik Stadium 3',
            'Penyakit Ginjal Kronik Stadium 4',
            'Asma Bronkial terkontrol',
            'Asma Bronkial eksaserbasi akut',
            'Hipertensi dengan Diabetes Mellitus',
            'Sindrom Metabolik',
        ];

        $therapyPlans = [
            'Modifikasi gaya hidup, diet rendah garam dan gula',
            'Terapi farmakologi sesuai resep, kontrol rutin',
            'Olahraga teratur 30 menit/hari, diet seimbang',
            'Monitoring gula darah harian, diet diabetes',
            'Pembatasan cairan, diet rendah protein',
            'Hindari pemicu asma, gunakan inhaler sesuai anjuran',
        ];

        $doctorAdvices = [
            'Kontrol rutin setiap bulan, jaga pola makan',
            'Hindari makanan tinggi garam dan lemak',
            'Olahraga teratur dan istirahat cukup',
            'Minum obat teratur sesuai jadwal',
            'Segera ke IGD jika keluhan memberat',
            'Catat gula darah harian di buku kontrol',
        ];

        foreach ($completedBookings as $booking) {
            $tanggalKonsultasi = Carbon::parse($booking->tanggal_konsultasi);
            $mulaiAt = Carbon::parse($booking->tanggal_konsultasi)->setTimeFromTimeString($booking->jam_mulai);
            $selesaiAt = $mulaiAt->copy()->addMinutes(rand(20, 40));

            Consultation::create([
                'booking_id' => $booking->id,
                'patient_id' => $booking->patient_id,
                'doctor_id' => $booking->doctor_id,
                'tanggal' => $tanggalKonsultasi,
                'mulai_at' => $mulaiAt,
                'selesai_at' => $selesaiAt,
                'anamnesis' => $booking->keluhan . '. ' . [
                    'Keluhan dirasakan sejak 3 hari yang lalu.',
                    'Keluhan memberat sejak kemarin.',
                    'Keluhan hilang timbul.',
                    'Keluhan konstan sepanjang hari.',
                    'Keluhan membaik dengan istirahat.',
                ][array_rand([0, 1, 2, 3, 4])],
                'pemeriksaan_fisik' => 'Keadaan umum baik, kesadaran compos mentis. ' . [
                    'Konjungtiva tidak anemis, sklera tidak ikterik.',
                    'Thorax simetris, suara napas vesikuler.',
                    'Abdomen supel, bising usus normal.',
                ][array_rand([0, 1, 2])],
                'tekanan_darah' => rand(110, 160) . '/' . rand(70, 100),
                'berat_badan' => rand(50, 90) + (rand(0, 9) / 10),
                'tinggi_badan' => rand(150, 180),
                'suhu_tubuh' => 36 + (rand(0, 15) / 10),
                'saturasi_o2' => rand(95, 100),
                'gula_darah' => rand(80, 250),
                'diagnosa' => $diagnoses[array_rand($diagnoses)],
                'icd_code' => 'E' . rand(10, 14) . '.' . rand(0, 9),
                'rencana_terapi' => $therapyPlans[array_rand($therapyPlans)],
                'saran_dokter' => $doctorAdvices[array_rand($doctorAdvices)],
                'tindak_lanjut' => ['none', 'kontrol', 'rujukan'][array_rand(['none', 'kontrol', 'rujukan'])],
                'tanggal_kontrol' => rand(0, 1) ? $tanggalKonsultasi->copy()->addWeeks(rand(1, 4)) : null,
                'status' => 'completed',
            ]);
        }

        $this->command->info('Consultation seeder completed! Total: ' . Consultation::count());
    }
}
