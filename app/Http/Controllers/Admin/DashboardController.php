<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Prescription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => User::role('pasien')->count(),
            'total_doctors' => User::role('dokter')->count(),
            'total_nurses' => User::role('perawat')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'today_consultations' => Consultation::whereDate('tanggal', today())->count(),
            'total_prescriptions' => Prescription::count(),
            'completed_consultations' => Consultation::where('status', 'completed')->count(),
            'total_bookings' => Booking::count(),
        ];
        
        $recentBookings = Booking::with(['patient', 'doctor', 'chronicCategory'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Data untuk grafik - Booking per bulan (6 bulan terakhir)
        $bookingsByMonth = [];
        $consultationsByMonth = [];
        $months = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $bookingsByMonth[] = Booking::whereYear('tanggal_konsultasi', $date->year)
                ->whereMonth('tanggal_konsultasi', $date->month)
                ->count();
                
            $consultationsByMonth[] = Consultation::whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->count();
        }
        
        // Booking by status
        $bookingByStatus = Booking::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        
        // Top 5 chronic categories
        $topChronicCategories = Booking::selectRaw('chronic_category_id, COUNT(*) as total')
            ->whereNotNull('chronic_category_id')
            ->groupBy('chronic_category_id')
            ->orderByDesc('total')
            ->take(5)
            ->with('chronicCategory')
            ->get();
        
        return view('admin.dashboard', compact(
            'stats', 
            'recentBookings', 
            'recentUsers',
            'months',
            'bookingsByMonth',
            'consultationsByMonth',
            'bookingByStatus',
            'topChronicCategories'
        ));
    }
}
