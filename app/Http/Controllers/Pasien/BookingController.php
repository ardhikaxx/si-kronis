<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\DoctorProfile;
use App\Models\DoctorSchedule;
use App\Models\User;
use App\Models\ChronicCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookingsAsPatient()
            ->with(['doctor', 'chronicCategory'])
            ->orderBy('tanggal_konsultasi', 'desc')
            ->paginate(10);

        return view('pasien.konsultasi.index', compact('bookings'));
    }

    public function create()
    {
        $doctors = User::role('dokter')->with('doctorProfile')->get();
        $categories = ChronicCategory::where('is_active', true)->get();
        
        return view('pasien.konsultasi.booking', compact('doctors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'tanggal_konsultasi' => 'required|date|after:today',
            'jam_mulai' => 'required|date_format:H:i',
            'keluhan' => 'required|min:10',
            'chronic_category_id' => 'nullable|exists:chronic_categories,id',
        ]);

        // Simple validation for schedule conflict/availability (can be enhanced)
        // Check if doctor has schedule on that day (this is a simplified check)
        // Ideally we should check doctor_schedules table for the specific day of week

        // Generate Booking Code: BK-YYYYMMDD-XXXX
        $dateCode = now()->format('Ymd');
        $count = Booking::whereDate('created_at', today())->count() + 1;
        $bookingCode = 'BK-' . $dateCode . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        // Jam selesai = Jam mulai + 30 mins (default)
        $jamSelesai = \Carbon\Carbon::parse($request->jam_mulai)->addMinutes(30)->format('H:i');

        Booking::create([
            'kode_booking' => $bookingCode,
            'patient_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'tanggal_konsultasi' => $request->tanggal_konsultasi,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $jamSelesai,
            'keluhan' => $request->keluhan,
            'chronic_category_id' => $request->chronic_category_id,
            'status' => 'pending',
            'tipe_konsultasi' => $request->tipe_konsultasi ?? 'online',
        ]);

        return redirect()->route('pasien.konsultasi.index')->with('success', 'Janji temu berhasil dibuat! Menunggu konfirmasi.');
    }

    public function show($id)
    {
        $booking = Booking::with(['doctor.doctorProfile', 'consultation', 'chronicCategory'])
            ->where('patient_id', Auth::id())
            ->findOrFail($id);

        return view('pasien.konsultasi.detail', compact('booking'));
    }
}
