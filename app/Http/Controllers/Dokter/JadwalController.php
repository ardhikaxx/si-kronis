<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use App\Models\DoctorLeave;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $schedules = DoctorSchedule::where('doctor_id', auth()->id())
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get();
        
        $leaves = DoctorLeave::where('doctor_id', auth()->id())
            ->where('tanggal_selesai', '>=', today())
            ->orderBy('tanggal_mulai')
            ->get();
        
        return view('dokter.jadwal.index', compact('schedules', 'leaves'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kuota' => 'required|integer|min:1|max:50',
            'is_active' => 'boolean',
        ]);

        try {
            DoctorSchedule::create([
                'doctor_id' => auth()->id(),
                'hari' => $validated['hari'],
                'jam_mulai' => $validated['jam_mulai'],
                'jam_selesai' => $validated['jam_selesai'],
                'kuota' => $validated['kuota'],
                'is_active' => $request->boolean('is_active', true),
            ]);
            
            return back()->with('success', 'Jadwal berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $schedule = DoctorSchedule::where('doctor_id', auth()->id())->findOrFail($id);
        
        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kuota' => 'required|integer|min:1|max:50',
            'is_active' => 'boolean',
        ]);

        try {
            $schedule->update($validated);
            
            return back()->with('success', 'Jadwal berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $schedule = DoctorSchedule::where('doctor_id', auth()->id())->findOrFail($id);
            $schedule->delete();
            
            return back()->with('success', 'Jadwal berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
