<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Consultation;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResepController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::where('doctor_id', auth()->id())
            ->with(['patient', 'consultation', 'items'])
            ->orderBy('tanggal_resep', 'desc')
            ->paginate(15);
        
        return view('dokter.resep.index', compact('prescriptions'));
    }

    public function create(Request $request)
    {
        $consultationId = $request->input('consultation_id');
        $consultation = null;
        
        if ($consultationId) {
            $consultation = Consultation::where('doctor_id', auth()->id())
                ->with(['patient', 'booking'])
                ->findOrFail($consultationId);
        }
        
        $medicines = Medicine::where('is_active', true)->orderBy('nama')->get();
        
        return view('dokter.resep.create', compact('consultation', 'medicines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
            'catatan_umum' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'nullable|exists:medicines,id',
            'items.*.nama_obat' => 'required|string|max:200',
            'items.*.dosis' => 'required|string|max:100',
            'items.*.frekuensi' => 'required|string|max:100',
            'items.*.durasi' => 'nullable|string|max:100',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.instruksi' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            
            $consultation = Consultation::where('doctor_id', auth()->id())
                ->findOrFail($validated['consultation_id']);
            
            // Generate kode resep
            $kodeResep = 'RX-' . now()->format('Ymd') . '-' . 
                str_pad(Prescription::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            
            $prescription = Prescription::create([
                'kode_resep' => $kodeResep,
                'consultation_id' => $consultation->id,
                'patient_id' => $consultation->patient_id,
                'doctor_id' => auth()->id(),
                'tanggal_resep' => now()->toDateString(),
                'catatan_umum' => $validated['catatan_umum'] ?? null,
                'status' => 'issued',
            ]);
            
            foreach ($validated['items'] as $item) {
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $item['medicine_id'] ?? null,
                    'nama_obat' => $item['nama_obat'],
                    'dosis' => $item['dosis'],
                    'frekuensi' => $item['frekuensi'],
                    'durasi' => $item['durasi'] ?? null,
                    'jumlah' => $item['jumlah'],
                    'instruksi' => $item['instruksi'] ?? null,
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('dokter.resep.show', $prescription->id)
                ->with('success', 'Resep berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $prescription = Prescription::where('doctor_id', auth()->id())
            ->with([
                'patient.profile',
                'consultation.booking',
                'items.medicine'
            ])
            ->findOrFail($id);
        
        return view('dokter.resep.show', compact('prescription'));
    }
}
