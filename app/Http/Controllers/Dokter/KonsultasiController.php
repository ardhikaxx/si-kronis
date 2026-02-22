<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Consultation;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::where('doctor_id', auth()->id())
            ->with(['patient', 'chronicCategory', 'consultation']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date')) {
            $query->whereDate('tanggal_konsultasi', $request->date);
        }
        
        $bookings = $query->orderBy('tanggal_konsultasi', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(15);
        
        return view('dokter.konsultasi.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::where('doctor_id', auth()->id())
            ->with([
                'patient.profile',
                'patient.chronicConditions.chronicCategory',
                'chronicCategory',
                'consultation.prescription.items.medicine',
                'labResults'
            ])
            ->findOrFail($id);
        
        return view('dokter.konsultasi.show', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::where('doctor_id', auth()->id())->findOrFail($id);
        
        $validated = $request->validate([
            'anamnesis' => 'required|string',
            'pemeriksaan_fisik' => 'nullable|string',
            'tekanan_darah' => 'nullable|string|max:20',
            'berat_badan' => 'nullable|numeric|min:0',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'suhu_tubuh' => 'nullable|numeric|min:0',
            'saturasi_o2' => 'nullable|integer|min:0|max:100',
            'gula_darah' => 'nullable|numeric|min:0',
            'diagnosa' => 'required|string',
            'icd_code' => 'nullable|string|max:20',
            'rencana_terapi' => 'nullable|string',
            'saran_dokter' => 'nullable|string',
            'tindak_lanjut' => 'required|in:none,kontrol,rujukan,rawat_inap',
            'tanggal_kontrol' => 'nullable|date|after:today',
        ]);

        try {
            $consultation = Consultation::updateOrCreate(
                ['booking_id' => $booking->id],
                [
                    'patient_id' => $booking->patient_id,
                    'doctor_id' => $booking->doctor_id,
                    'tanggal' => $booking->tanggal_konsultasi,
                    'mulai_at' => $booking->consultation->mulai_at ?? now(),
                    'selesai_at' => now(),
                    'anamnesis' => $validated['anamnesis'],
                    'pemeriksaan_fisik' => $validated['pemeriksaan_fisik'] ?? null,
                    'tekanan_darah' => $validated['tekanan_darah'] ?? null,
                    'berat_badan' => $validated['berat_badan'] ?? null,
                    'tinggi_badan' => $validated['tinggi_badan'] ?? null,
                    'suhu_tubuh' => $validated['suhu_tubuh'] ?? null,
                    'saturasi_o2' => $validated['saturasi_o2'] ?? null,
                    'gula_darah' => $validated['gula_darah'] ?? null,
                    'diagnosa' => $validated['diagnosa'],
                    'icd_code' => $validated['icd_code'] ?? null,
                    'rencana_terapi' => $validated['rencana_terapi'] ?? null,
                    'saran_dokter' => $validated['saran_dokter'] ?? null,
                    'tindak_lanjut' => $validated['tindak_lanjut'],
                    'tanggal_kontrol' => $validated['tanggal_kontrol'] ?? null,
                    'status' => 'completed',
                ]
            );
            
            $booking->update(['status' => 'completed']);
            
            return redirect()->route('dokter.konsultasi.show', $booking->id)
                ->with('success', 'Data konsultasi berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
