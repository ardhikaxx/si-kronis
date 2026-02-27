<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\PrescriptionRefill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResepController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::where('patient_id', Auth::id())
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

    public function requestRefill(Request $request, $id)
    {
        $prescription = Prescription::where('patient_id', Auth::id())->findOrFail($id);

        $refill = PrescriptionRefill::create([
            'prescription_id' => $prescription->id,
            'patient_id' => Auth::id(),
            'doctor_id' => $prescription->doctor_id,
            'catatan' => $request->catatan,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan isi ulang resep berhasil dikirim');
    }

    public function myRefills()
    {
        $refills = PrescriptionRefill::where('patient_id', Auth::id())
            ->with(['prescription', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.resep.refills', compact('refills'));
    }
}
