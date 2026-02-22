<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\DoctorSchedule;
use App\Models\DoctorLeave;
use Carbon\Carbon;

class BookingService
{
    public function createBooking($user, array $data)
    {
        // Validasi jadwal dokter
        $tanggal = Carbon::parse($data['tanggal_konsultasi']);
        $hari = $this->getIndonesianDay($tanggal->dayOfWeek);
        
        $schedule = DoctorSchedule::where('doctor_id', $data['doctor_id'])
            ->where('hari', $hari)
            ->where('is_active', true)
            ->first();
        
        if (!$schedule) {
            throw new \Exception('Dokter tidak memiliki jadwal praktik pada hari tersebut.');
        }
        
        // Cek apakah dokter sedang cuti
        $isOnLeave = DoctorLeave::where('doctor_id', $data['doctor_id'])
            ->where('tanggal_mulai', '<=', $data['tanggal_konsultasi'])
            ->where('tanggal_selesai', '>=', $data['tanggal_konsultasi'])
            ->exists();
        
        if ($isOnLeave) {
            throw new \Exception('Dokter sedang tidak tersedia pada tanggal tersebut.');
        }
        
        // Cek kuota
        $bookedCount = Booking::where('doctor_id', $data['doctor_id'])
            ->whereDate('tanggal_konsultasi', $data['tanggal_konsultasi'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
        
        if ($bookedCount >= $schedule->kuota) {
            throw new \Exception('Kuota konsultasi untuk tanggal tersebut sudah penuh.');
        }
        
        // Generate kode booking
        $kodeBooking = 'BK-' . now()->format('Ymd') . '-' . 
            str_pad(Booking::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
        
        // Hitung jam selesai (asumsi 30 menit per konsultasi)
        $jamMulai = Carbon::parse($data['jam_mulai']);
        $jamSelesai = $jamMulai->copy()->addMinutes(30);
        
        return Booking::create([
            'kode_booking' => $kodeBooking,
            'patient_id' => $user->id,
            'doctor_id' => $data['doctor_id'],
            'tanggal_konsultasi' => $data['tanggal_konsultasi'],
            'jam_mulai' => $data['jam_mulai'],
            'jam_selesai' => $jamSelesai->format('H:i'),
            'keluhan' => $data['keluhan'],
            'chronic_category_id' => $data['chronic_category_id'] ?? null,
            'tipe_konsultasi' => $data['tipe_konsultasi'],
            'catatan_pasien' => $data['catatan_pasien'] ?? null,
            'status' => 'pending',
        ]);
    }
    
    private function getIndonesianDay($dayOfWeek)
    {
        $days = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];
        
        return $days[$dayOfWeek];
    }
}
