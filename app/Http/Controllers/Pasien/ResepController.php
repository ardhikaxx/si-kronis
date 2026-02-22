<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResepController extends Controller
{
    public function index()
    {
        $prescriptions = Auth::user()->prescriptionsAsPatient()
            ->with(['doctor', 'consultation'])
            ->orderBy('tanggal_resep', 'desc')
            ->paginate(10);

        return view('pasien.resep.index', compact('prescriptions'));
    }

    public function show($id)
    {
        $prescription = Prescription::with(['doctor.doctorProfile', 'prescriptionItems', 'consultation'])
            ->where('patient_id', Auth::id())
            ->findOrFail($id);

        return view('pasien.resep.detail', compact('prescription'));
    }
}
