<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\LabResult;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'today_appointments' => Booking::whereDate('tanggal_konsultasi', today())
                ->whereIn('status', ['confirmed', 'completed'])
                ->count(),
            'pending_lab_results' => LabResult::where('status', 'pending')->count(),
            'completed_today' => Consultation::whereDate('tanggal', today())
                ->where('status', 'completed')
                ->count(),
            'confirmed_today' => Booking::whereDate('tanggal_konsultasi', today())
                ->where('status', 'confirmed')
                ->count(),
        ];
        
        $pendingBookings = Booking::where('status', 'pending')
            ->with(['patient', 'doctor', 'chronicCategory'])
            ->orderBy('tanggal_konsultasi')
            ->orderBy('jam_mulai')
            ->take(10)
            ->get();
        
        $todayAppointments = Booking::whereDate('tanggal_konsultasi', today())
            ->whereIn('status', ['confirmed', 'completed'])
            ->with(['patient', 'doctor', 'chronicCategory'])
            ->orderBy('jam_mulai')
            ->get();
        
        $pendingLabResults = LabResult::where('status', 'pending')
            ->with(['patient', 'consultation'])
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->take(5)
            ->get();
        
        // Data untuk grafik - Booking per hari (7 hari terakhir)
        $bookingsByDay = [];
        $days = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->format('d M');
            
            $bookingsByDay[] = Booking::whereDate('tanggal_konsultasi', $date->toDateString())
                ->count();
        }
        
        // Booking by status untuk minggu ini
        $weeklyBookingByStatus = Booking::whereBetween('tanggal_konsultasi', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        
        return view('perawat.dashboard', compact(
            'stats', 
            'pendingBookings', 
            'todayAppointments', 
            'pendingLabResults',
            'days',
            'bookingsByDay',
            'weeklyBookingByStatus'
        ));
    }
}
