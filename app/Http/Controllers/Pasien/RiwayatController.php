<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $consultations = Auth::user()->consultationsAsPatient()
            ->with(['doctor.doctorProfile', 'booking'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('pasien.riwayat.index', compact('consultations'));
    }

    public function show($id)
    {
        $consultation = Consultation::where('patient_id', Auth::id())
            ->with([
                'doctor.doctorProfile',
                'booking.chronicCategory',
                'prescription.prescriptionItems.medicine'
            ])
            ->findOrFail($id);

        return view('pasien.riwayat.detail', compact('consultation'));
    }
}
