<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\LabResult;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'nama_lab' => 'required|string|max:150',
            'tanggal_lab' => 'required|date',
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
            'catatan' => 'nullable|string',
        ]);

        try {
            $file = $request->file('file');
            $patientId = $validated['patient_id'];
            
            $path = $file->store("lab-results/{$patientId}", 'private');
            
            LabResult::create([
                'patient_id' => $patientId,
                'booking_id' => $validated['booking_id'] ?? null,
                'nama_lab' => $validated['nama_lab'],
                'tanggal_lab' => $validated['tanggal_lab'],
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'catatan' => $validated['catatan'] ?? null,
                'uploaded_by' => auth()->id(),
            ]);
            
            return back()->with('success', 'Hasil lab berhasil diupload.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
