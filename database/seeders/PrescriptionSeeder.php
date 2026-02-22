<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Consultation;
use App\Models\Medicine;
use Carbon\Carbon;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $consultations = Consultation::with('booking')->get();
        $medicines = Medicine::where('is_active', true)->get();

        if ($consultations->isEmpty() || $medicines->isEmpty()) {
            $this->command->warn('Pastikan sudah ada data konsultasi dan obat!');
            return;
        }

        $prescriptionNumber = 1;

        // Buat resep untuk 80% konsultasi (sisanya tanpa resep)
        $consultationsWithPrescription = $consultations->random(intval($consultations->count() * 0.8));

        foreach ($consultationsWithPrescription as $consultation) {
            $tanggalResep = Carbon::parse($consultation->tanggal);
            
            $prescription = Prescription::create([
                'kode_resep' => 'RX-' . $tanggalResep->format('Ymd') . '-' . str_pad($prescriptionNumber++, 4, '0', STR_PAD_LEFT),
                'consultation_id' => $consultation->id,
                'patient_id' => $consultation->patient_id,
                'doctor_id' => $consultation->doctor_id,
                'tanggal_resep' => $tanggalResep,
                'catatan_umum' => rand(0, 1) ? 'Minum obat sesuai anjuran, jangan dihentikan tanpa konsultasi dokter' : null,
                'status' => ['issued', 'dispensed'][array_rand(['issued', 'dispensed'])],
                'dispensed_by' => rand(0, 1) ? \App\Models\User::role('perawat')->first()->id : null,
                'dispensed_at' => rand(0, 1) ? $tanggalResep->copy()->addHours(rand(1, 4)) : null,
            ]);

            // Tambahkan 2-5 item obat per resep
            $numItems = rand(2, 5);
            $selectedMedicines = $medicines->random(min($numItems, $medicines->count()));

            $dosages = ['1 tablet', '2 tablet', '1 kapsul', '2 kapsul', '5 ml', '10 ml', '1 sendok takar'];
            $frequencies = ['1x sehari', '2x sehari', '3x sehari', '1x sehari malam', '2x sehari pagi dan malam'];
            $durations = ['7 hari', '14 hari', '30 hari', '1 bulan', '2 minggu'];
            $instructions = [
                'Diminum setelah makan',
                'Diminum sebelum makan',
                'Diminum bersama makanan',
                'Diminum saat perut kosong',
                'Diminum malam sebelum tidur',
            ];

            foreach ($selectedMedicines as $medicine) {
                $dosage = $dosages[array_rand($dosages)];
                $frequency = $frequencies[array_rand($frequencies)];
                $duration = $durations[array_rand($durations)];
                
                // Hitung jumlah berdasarkan frekuensi dan durasi
                preg_match('/(\d+)x/', $frequency, $freqMatch);
                preg_match('/(\d+)/', $duration, $durMatch);
                $freqPerDay = isset($freqMatch[1]) ? (int)$freqMatch[1] : 1;
                $days = isset($durMatch[1]) ? (int)$durMatch[1] : 7;
                if (strpos($duration, 'bulan') !== false) {
                    $days = $days * 30;
                }
                $quantity = $freqPerDay * $days;

                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $medicine->id,
                    'nama_obat' => $medicine->nama,
                    'dosis' => $dosage,
                    'frekuensi' => $frequency,
                    'durasi' => $duration,
                    'jumlah' => $quantity,
                    'instruksi' => $instructions[array_rand($instructions)],
                ]);
            }
        }

        $this->command->info('Prescription seeder completed!');
        $this->command->info('Total prescriptions: ' . Prescription::count());
        $this->command->info('Total prescription items: ' . PrescriptionItem::count());
        $this->command->info('Resep bulan ini: ' . Prescription::whereMonth('tanggal_resep', Carbon::now()->month)->count());
    }
}
