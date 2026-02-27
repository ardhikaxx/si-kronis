<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Prescription;
use App\Models\LabResult;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function exportPdf()
    {
        $patient = Auth::user();
        
        $consultations = Consultation::where('patient_id', $patient->id)
            ->with(['doctor.doctorProfile', 'prescription.prescriptionItems.medicine'])
            ->orderBy('tanggal', 'desc')
            ->get();

        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->with(['doctor', 'prescriptionItems.medicine'])
            ->orderBy('tanggal_resep', 'desc')
            ->get();

        $labResults = LabResult::where('patient_id', $patient->id)
            ->orderBy('tanggal_lab', 'desc')
            ->get();

        $pdf = Pdf::loadView('pasien.riwayat.pdf', [
            'patient' => $patient,
            'consultations' => $consultations,
            'prescriptions' => $prescriptions,
            'labResults' => $labResults,
            'tanggal_cetak' => now()->format('d F Y')
        ]);

        return $pdf->download('riwayat-medis-' . $patient->name . '.pdf');
    }
}
