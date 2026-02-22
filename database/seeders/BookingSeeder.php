<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\ChronicCategory;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $patients = User::role('pasien')->get();
        $doctors = User::role('dokter')->get();
        $nurses = User::role('perawat')->get();
        $chronicCategories = ChronicCategory::all();

        if ($patients->isEmpty() || $doctors->isEmpty() || $chronicCategories->isEmpty()) {
            $this->command->warn('Pastikan sudah ada data pasien, dokter, dan kategori kronis!');
            return;
        }

        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $keluhan = [
            'Gula darah tidak stabil',
            'Tekanan darah tinggi',
            'Nyeri dada',
            'Sesak napas',
            'Pusing dan lemas',
            'Kaki bengkak',
            'Sering haus dan lapar',
            'Penglihatan kabur',
            'Jantung berdebar',
            'Mudah lelah',
            'Sakit kepala',
            'Mual dan muntah',
            'Kontrol rutin',
            'Cek kesehatan',
            'Konsultasi obat',
        ];

        $bookingNumber = 1;

        // 1. BOOKING HARI INI - Setiap dokter mendapat 5-8 booking
        $today = Carbon::today();
        $this->command->info('Creating bookings for TODAY...');
        
        foreach ($doctors as $doctor) {
            $numBookings = rand(5, 8);
            for ($i = 0; $i < $numBookings; $i++) {
                $patient = $patients->random();
                $category = $chronicCategories->random();
                $hour = 8 + $i;
                
                // Status: 30% pending, 40% confirmed, 20% completed, 10% cancelled
                $rand = rand(1, 100);
                if ($rand <= 30) {
                    $status = 'pending';
                } elseif ($rand <= 70) {
                    $status = 'confirmed';
                } elseif ($rand <= 90) {
                    $status = 'completed';
                } else {
                    $status = 'cancelled';
                }

                $nurse = $nurses->random();

                Booking::create([
                    'kode_booking' => 'BK-' . $today->format('Ymd') . '-' . str_pad($bookingNumber++, 4, '0', STR_PAD_LEFT),
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'chronic_category_id' => $category->id,
                    'tanggal_konsultasi' => $today->format('Y-m-d'),
                    'jam_mulai' => sprintf('%02d:00:00', $hour),
                    'jam_selesai' => sprintf('%02d:30:00', $hour),
                    'keluhan' => $keluhan[array_rand($keluhan)],
                    'catatan_pasien' => rand(0, 1) ? 'Mohon persiapkan hasil lab terbaru' : null,
                    'status' => $status,
                    'confirmed_by' => $status != 'pending' ? $nurse->id : null,
                    'confirmed_at' => $status != 'pending' ? $today->copy()->subHours(rand(1, 3)) : null,
                    'cancelled_by' => $status == 'cancelled' ? $patient->id : null,
                    'cancelled_at' => $status == 'cancelled' ? $today->copy()->subHours(rand(1, 2)) : null,
                    'alasan_batal' => $status == 'cancelled' ? 'Berhalangan hadir' : null,
                ]);
            }
        }

        // 2. BOOKING BESOK - Setiap dokter mendapat 4-6 booking
        $tomorrow = Carbon::tomorrow();
        $this->command->info('Creating bookings for TOMORROW...');
        
        foreach ($doctors as $doctor) {
            $numBookings = rand(4, 6);
            for ($i = 0; $i < $numBookings; $i++) {
                $patient = $patients->random();
                $category = $chronicCategories->random();
                $hour = 8 + $i;
                
                // Status: 60% pending, 40% confirmed
                $status = rand(1, 100) <= 60 ? 'pending' : 'confirmed';
                $nurse = $nurses->random();

                Booking::create([
                    'kode_booking' => 'BK-' . $tomorrow->format('Ymd') . '-' . str_pad($bookingNumber++, 4, '0', STR_PAD_LEFT),
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'chronic_category_id' => $category->id,
                    'tanggal_konsultasi' => $tomorrow->format('Y-m-d'),
                    'jam_mulai' => sprintf('%02d:00:00', $hour),
                    'jam_selesai' => sprintf('%02d:30:00', $hour),
                    'keluhan' => $keluhan[array_rand($keluhan)],
                    'catatan_pasien' => rand(0, 1) ? 'Pasien baru' : null,
                    'status' => $status,
                    'confirmed_by' => $status == 'confirmed' ? $nurse->id : null,
                    'confirmed_at' => $status == 'confirmed' ? now()->subHours(rand(1, 5)) : null,
                ]);
            }
        }

        // 3. BOOKING 7 HARI KE DEPAN - Setiap dokter mendapat 2-3 booking per hari
        $this->command->info('Creating bookings for NEXT 7 DAYS...');
        
        for ($day = 2; $day <= 7; $day++) {
            $date = Carbon::today()->addDays($day);
            
            // Skip weekend
            if ($date->isWeekend()) continue;
            
            foreach ($doctors as $doctor) {
                $numBookings = rand(2, 3);
                for ($i = 0; $i < $numBookings; $i++) {
                    $patient = $patients->random();
                    $category = $chronicCategories->random();
                    $hour = 9 + ($i * 2);
                    
                    $status = rand(1, 100) <= 70 ? 'pending' : 'confirmed';
                    $nurse = $nurses->random();

                    Booking::create([
                        'kode_booking' => 'BK-' . $date->format('Ymd') . '-' . str_pad($bookingNumber++, 4, '0', STR_PAD_LEFT),
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'chronic_category_id' => $category->id,
                        'tanggal_konsultasi' => $date->format('Y-m-d'),
                        'jam_mulai' => sprintf('%02d:00:00', $hour),
                        'jam_selesai' => sprintf('%02d:30:00', $hour),
                        'keluhan' => $keluhan[array_rand($keluhan)],
                        'status' => $status,
                        'confirmed_by' => $status == 'confirmed' ? $nurse->id : null,
                        'confirmed_at' => $status == 'confirmed' ? now()->subHours(rand(1, 24)) : null,
                    ]);
                }
            }
        }

        // 4. BOOKING BULAN INI (data historis) - Setiap dokter mendapat 3-5 booking per hari kerja
        $this->command->info('Creating bookings for THIS MONTH...');
        
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::yesterday();
        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Skip weekend
            if ($date->isWeekend()) continue;
            
            foreach ($doctors as $doctor) {
                $numBookings = rand(3, 5);
                for ($i = 0; $i < $numBookings; $i++) {
                    $patient = $patients->random();
                    $category = $chronicCategories->random();
                    $hour = 8 + $i;
                    
                    // Status historis: 70% completed, 20% cancelled, 10% confirmed
                    $rand = rand(1, 100);
                    if ($rand <= 70) {
                        $status = 'completed';
                    } elseif ($rand <= 90) {
                        $status = 'cancelled';
                    } else {
                        $status = 'confirmed';
                    }

                    $nurse = $nurses->random();

                    Booking::create([
                        'kode_booking' => 'BK-' . $date->format('Ymd') . '-' . str_pad($bookingNumber++, 4, '0', STR_PAD_LEFT),
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'chronic_category_id' => $category->id,
                        'tanggal_konsultasi' => $date->format('Y-m-d'),
                        'jam_mulai' => sprintf('%02d:00:00', $hour),
                        'jam_selesai' => sprintf('%02d:30:00', $hour),
                        'keluhan' => $keluhan[array_rand($keluhan)],
                        'status' => $status,
                        'confirmed_by' => $nurse->id,
                        'confirmed_at' => $date->copy()->addHours(rand(1, 3)),
                        'cancelled_by' => $status == 'cancelled' ? $patient->id : null,
                        'cancelled_at' => $status == 'cancelled' ? $date->copy()->addHours(rand(4, 6)) : null,
                        'alasan_batal' => $status == 'cancelled' ? ['Berhalangan hadir', 'Kondisi membaik', 'Jadwal bentrok'][array_rand(['Berhalangan hadir', 'Kondisi membaik', 'Jadwal bentrok'])] : null,
                    ]);
                }
            }
        }

        // 5. BOOKING 6 BULAN TERAKHIR (untuk grafik dashboard dokter) - Setiap dokter mendapat 2-4 booking per hari kerja
        $this->command->info('Creating bookings for LAST 6 MONTHS (for charts)...');
        
        $startDate = Carbon::now()->subMonths(6)->startOfMonth();
        $endDate = Carbon::now()->subMonth()->endOfMonth();
        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Skip weekend
            if ($date->isWeekend()) continue;
            
            foreach ($doctors as $doctor) {
                $numBookings = rand(2, 4);
                for ($i = 0; $i < $numBookings; $i++) {
                    $patient = $patients->random();
                    $category = $chronicCategories->random();
                    $hour = 9 + ($i * 2);
                    
                    // Status: 85% completed, 10% cancelled, 5% confirmed
                    $rand = rand(1, 100);
                    if ($rand <= 85) {
                        $status = 'completed';
                    } elseif ($rand <= 95) {
                        $status = 'cancelled';
                    } else {
                        $status = 'confirmed';
                    }

                    $nurse = $nurses->random();

                    Booking::create([
                        'kode_booking' => 'BK-' . $date->format('Ymd') . '-' . str_pad($bookingNumber++, 4, '0', STR_PAD_LEFT),
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'chronic_category_id' => $category->id,
                        'tanggal_konsultasi' => $date->format('Y-m-d'),
                        'jam_mulai' => sprintf('%02d:00:00', $hour),
                        'jam_selesai' => sprintf('%02d:30:00', $hour),
                        'keluhan' => $keluhan[array_rand($keluhan)],
                        'status' => $status,
                        'confirmed_by' => $nurse->id,
                        'confirmed_at' => $date->copy()->addHours(rand(1, 3)),
                        'cancelled_by' => $status == 'cancelled' ? $patient->id : null,
                        'cancelled_at' => $status == 'cancelled' ? $date->copy()->addHours(rand(4, 6)) : null,
                        'alasan_batal' => $status == 'cancelled' ? 'Berhalangan hadir' : null,
                    ]);
                }
            }
        }

        $totalBookings = Booking::count();
        $todayBookings = Booking::whereDate('tanggal_konsultasi', Carbon::today())->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $completedBookings = Booking::where('status', 'completed')->count();

        $this->command->info('');
        $this->command->info('=== BOOKING SEEDER COMPLETED ===');
        $this->command->info('Total bookings: ' . $totalBookings);
        $this->command->info('- Hari ini: ' . $todayBookings);
        $this->command->info('- Pending: ' . $pendingBookings);
        $this->command->info('- Confirmed: ' . $confirmedBookings);
        $this->command->info('- Completed: ' . $completedBookings);
        $this->command->info('');
        
        // Show per doctor stats
        foreach ($doctors as $doctor) {
            $doctorBookings = Booking::where('doctor_id', $doctor->id)->count();
            $doctorToday = Booking::where('doctor_id', $doctor->id)->whereDate('tanggal_konsultasi', Carbon::today())->count();
            $doctorCompleted = Booking::where('doctor_id', $doctor->id)->where('status', 'completed')->count();
            $this->command->info($doctor->name . ': ' . $doctorBookings . ' total (' . $doctorToday . ' today, ' . $doctorCompleted . ' completed)');
        }
    }
}
