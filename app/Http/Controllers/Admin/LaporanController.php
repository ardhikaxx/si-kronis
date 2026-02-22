<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->toDateString());
        
        $stats = [
            'total_bookings' => Booking::whereBetween('tanggal_konsultasi', [$fromDate, $toDate])->count(),
            'completed_consultations' => Consultation::whereBetween('tanggal', [$fromDate, $toDate])
                ->where('status', 'completed')->count(),
            'total_prescriptions' => Prescription::whereBetween('tanggal_resep', [$fromDate, $toDate])->count(),
            'new_patients' => User::role('pasien')
                ->whereBetween('created_at', [$fromDate, $toDate])->count(),
        ];
        
        $bookingsByStatus = Booking::select('status', DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal_konsultasi', [$fromDate, $toDate])
            ->groupBy('status')
            ->get();
        
        $consultationsByDoctor = Consultation::select('doctor_id', DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$fromDate, $toDate])
            ->with('doctor')
            ->groupBy('doctor_id')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();
        
        $dailyBookings = Booking::select(
                DB::raw('DATE(tanggal_konsultasi) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('tanggal_konsultasi', [$fromDate, $toDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('admin.laporan.index', compact(
            'stats',
            'bookingsByStatus',
            'consultationsByDoctor',
            'dailyBookings',
            'fromDate',
            'toDate'
        ));
    }

    public function export(Request $request)
    {
        // Implementasi export Excel/PDF bisa ditambahkan di sini
        return back()->with('info', 'Fitur export sedang dalam pengembangan.');
    }
}
