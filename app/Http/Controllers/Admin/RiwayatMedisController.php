<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Consultation;
use App\Models\Prescription;
use App\Models\LabResult;
use Illuminate\Http\Request;

class RiwayatMedisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $patients = User::whereHas('roles', function($query) {
            $query->where('name', 'pasien');
        })
        ->when($search, function($query) use ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        })
        ->withCount(['consultationsAsPatient', 'prescriptionsAsPatient'])
        ->latest()
        ->paginate(10);

        return view('admin.riwayat-medis.index', compact('patients', 'search'));
    }

    public function show(User $patient)
    {
        $patient->load(['profile', 'chronicConditions']);
        
        $consultations = Consultation::where('patient_id', $patient->id)
            ->with(['doctor', 'prescription', 'labResults'])
            ->latest()
            ->paginate(10);

        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->with(['doctor', 'items'])
            ->latest()
            ->paginate(10);

        $labResults = LabResult::where('patient_id', $patient->id)
            ->with(['consultation'])
            ->latest()
            ->paginate(10);

        return view('admin.riwayat-medis.show', compact('patient', 'consultations', 'prescriptions', 'labResults'));
    }
}
