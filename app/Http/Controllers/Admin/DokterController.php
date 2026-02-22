<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('dokter')->with('doctorProfile');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('doctorProfile', function($q2) use ($search) {
                      $q2->where('spesialisasi', 'like', "%{$search}%");
                  });
            });
        }
        
        $doctors = $query->paginate(15);
        
        return view('admin.dokter.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
            
            'nip' => 'nullable|string|max:30|unique:doctor_profiles,nip',
            'str_number' => 'nullable|string|max:50',
            'spesialisasi' => 'nullable|string|max:100',
            'sub_spesialisasi' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:255',
            'pengalaman_tahun' => 'nullable|integer|min:0',
            'biaya_konsultasi' => 'nullable|numeric|min:0',
            'tentang' => 'nullable|string',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'is_active' => true,
            ]);
            
            $user->assignRole('dokter');
            
            DoctorProfile::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'] ?? null,
                'str_number' => $validated['str_number'] ?? null,
                'spesialisasi' => $validated['spesialisasi'] ?? null,
                'sub_spesialisasi' => $validated['sub_spesialisasi'] ?? null,
                'pendidikan' => $validated['pendidikan'] ?? null,
                'pengalaman_tahun' => $validated['pengalaman_tahun'] ?? 0,
                'biaya_konsultasi' => $validated['biaya_konsultasi'] ?? 0,
                'tentang' => $validated['tentang'] ?? null,
            ]);
            
            return redirect()->route('admin.dokter.index')
                ->with('success', 'Dokter berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $doctor = User::role('dokter')->with('doctorProfile')->findOrFail($id);
        
        return view('admin.dokter.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $doctor = User::role('dokter')->with('doctorProfile')->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|min:8|confirmed',
            
            'nip' => 'nullable|string|max:30|unique:doctor_profiles,nip,' . $doctor->doctorProfile->id,
            'str_number' => 'nullable|string|max:50',
            'spesialisasi' => 'nullable|string|max:100',
            'sub_spesialisasi' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:255',
            'pengalaman_tahun' => 'nullable|integer|min:0',
            'biaya_konsultasi' => 'nullable|numeric|min:0',
            'tentang' => 'nullable|string',
            'is_available' => 'boolean',
        ]);

        try {
            $doctor->name = $validated['name'];
            $doctor->email = $validated['email'];
            $doctor->phone = $validated['phone'];
            
            if ($request->filled('password')) {
                $doctor->password = Hash::make($validated['password']);
            }
            
            $doctor->save();
            
            $doctor->doctorProfile->update([
                'nip' => $validated['nip'] ?? null,
                'str_number' => $validated['str_number'] ?? null,
                'spesialisasi' => $validated['spesialisasi'] ?? null,
                'sub_spesialisasi' => $validated['sub_spesialisasi'] ?? null,
                'pendidikan' => $validated['pendidikan'] ?? null,
                'pengalaman_tahun' => $validated['pengalaman_tahun'] ?? 0,
                'biaya_konsultasi' => $validated['biaya_konsultasi'] ?? 0,
                'tentang' => $validated['tentang'] ?? null,
                'is_available' => $request->boolean('is_available', true),
            ]);
            
            return redirect()->route('admin.dokter.index')
                ->with('success', 'Data dokter berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $doctor = User::role('dokter')->findOrFail($id);
            $doctor->delete();
            
            return redirect()->route('admin.dokter.index')
                ->with('success', 'Dokter berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
