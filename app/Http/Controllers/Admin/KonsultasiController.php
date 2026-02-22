<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Consultation;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['patient', 'doctor', 'chronicCategory', 'consultation']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_booking', 'like', "%{$search}%")
                  ->orWhereHas('patient', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('doctor', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('from_date')) {
            $query->whereDate('tanggal_konsultasi', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('tanggal_konsultasi', '<=', $request->to_date);
        }
        
        $bookings = $query->orderBy('tanggal_konsultasi', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(15);
        
        return view('admin.konsultasi.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with([
            'patient.profile',
            'doctor.doctorProfile',
            'chronicCategory',
            'consultation.prescription.items',
            'labResults'
        ])->findOrFail($id);
        
        return view('admin.konsultasi.show', compact('booking'));
    }
}
