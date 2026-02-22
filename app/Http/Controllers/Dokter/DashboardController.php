<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Prescription;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'today_appointments' => Booking::where('doctor_id', $user->id)
                ->whereDate('tanggal_konsultasi', today())
                ->whereIn('status', ['confirmed', 'completed'])
                ->count(),
            'pending_consultations' => Booking::where('doctor_id', $user->id)
                ->where('status', 'confirmed')
                ->whereDate('tanggal_konsultasi', '<=', today())
                ->count(),
            'total_patients' => Consultation::where('doctor_id', $user->id)
                ->distinct('patient_id')
                ->count('patient_id'),
            'prescriptions_issued' => Prescription::where('doctor_id', $user->id)
                ->whereMonth('tanggal_resep', now()->month)
                ->count(),
            'total_consultations' => Consultation::where('doctor_id', $user->id)->count(),
        ];
        
        $todaySchedule = Booking::where('doctor_id', $user->id)
            ->whereDate('tanggal_konsultasi', today())
            ->with(['patient', 'chronicCategory'])
            ->orderBy('jam_mulai')
            ->get();
        
        $upcomingAppointments = Booking::where('doctor_id', $user->id)
            ->where('tanggal_konsultasi', '>', today())
            ->whereIn('status', ['confirmed'])
            ->with(['patient', 'chronicCategory'])
            ->orderBy('tanggal_konsultasi')
            ->orderBy('jam_mulai')
            ->take(5)
            ->get();
        
        $recentConsultations = Consultation::where('doctor_id', $user->id)
            ->with(['patient', 'booking'])
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();
        
        // Data untuk grafik - Konsultasi per bulan (6 bulan terakhir)
        $consultationsByMonth = [];
        $months = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $consultationsByMonth[] = Consultation::where('doctor_id', $user->id)
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->count();
        }
        
        // Konsultasi by chronic category
        $consultationsByCategory = Booking::where('doctor_id', $user->id)
            ->whereNotNull('chronic_category_id')
            ->selectRaw('chronic_category_id, COUNT(*) as total')
            ->groupBy('chronic_category_id')
            ->with('chronicCategory')
            ->get();
        
        return view('dokter.dashboard', compact(
            'stats', 
            'todaySchedule', 
            'upcomingAppointments', 
            'recentConsultations',
            'months',
            'consultationsByMonth',
            'consultationsByCategory'
        ));
    }
}
