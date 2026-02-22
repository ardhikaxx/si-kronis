<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\ChronicCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->userProfile;
        $chronicCategories = ChronicCategory::where('is_active', true)->get();

        return view('pasien.profil.index', compact('user', 'profile', 'chronicCategories'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'nik' => 'nullable|string|max:20|unique:user_profiles,nik,' . Auth::user()->userProfile->id,
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'chronic_conditions' => 'nullable|array',
            'chronic_conditions.*' => 'exists:chronic_categories,id',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $user->userProfile->update([
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'golongan_darah' => $request->golongan_darah,
        ]);

        // Update chronic conditions
        if ($request->has('chronic_conditions')) {
            // Delete existing conditions
            $user->chronicConditions()->delete();
            
            // Add new conditions
            foreach ($request->chronic_conditions as $categoryId) {
                $user->chronicConditions()->create([
                    'chronic_category_id' => $categoryId,
                ]);
            }
        } else {
            // If no conditions selected, delete all
            $user->chronicConditions()->delete();
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
