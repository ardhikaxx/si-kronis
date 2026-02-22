<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\LabResult;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabController extends Controller
{
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'nama_lab' => 'required|string|max:150',
            'tanggal_lab' => 'required|date',
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
            'catatan' => 'nullable|string',
        ]);

        try {
            $file = $request->file('file');
            $userId = auth()->id();
            
            $path = $file->store("lab-results/{$userId}", 'private');
            
            LabResult::create([
                'patient_id' => $userId,
                'booking_id' => $validated['booking_id'] ?? null,
                'nama_lab' => $validated['nama_lab'],
                'tanggal_lab' => $validated['tanggal_lab'],
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'catatan' => $validated['catatan'] ?? null,
                'uploaded_by' => $userId,
            ]);
            
            return back()->with('success', 'Hasil lab berhasil diupload.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
