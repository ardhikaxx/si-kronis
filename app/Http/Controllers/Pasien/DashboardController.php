<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Prescription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $upcomingBookings = Booking::where('patient_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('tanggal_konsultasi', '>=', now()->toDateString())
            ->with(['doctor.doctorProfile', 'chronicCategory'])
            ->orderBy('tanggal_konsultasi')
            ->orderBy('jam_mulai')
            ->take(3)
            ->get();
        
        $recentConsultations = Consultation::where('patient_id', $user->id)
            ->with(['doctor', 'booking'])
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();
        
        $activePrescriptions = Prescription::where('patient_id', $user->id)
            ->whereIn('status', ['issued', 'dispensed'])
            ->with('doctor')
            ->orderBy('tanggal_resep', 'desc')
            ->take(3)
            ->get();
        
        $chronicConditions = $user->chronicConditions()->with('chronicCategory')->get();
        
        $stats = [
            'total_consultations' => Consultation::where('patient_id', $user->id)->count(),
            'upcoming_bookings' => Booking::where('patient_id', $user->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->where('tanggal_konsultasi', '>=', now()->toDateString())
                ->count(),
            'active_prescriptions' => Prescription::where('patient_id', $user->id)
                ->whereIn('status', ['issued', 'dispensed'])
                ->count(),
        ];
        
        return view('pasien.dashboard', compact(
            'upcomingBookings',
            'recentConsultations',
            'activePrescriptions',
            'chronicConditions',
            'stats'
        ));
    }
}
