<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nama_generik', 'like', "%{$search}%")
                  ->orWhere('kode', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        $medicines = $query->orderBy('nama')->paginate(15);
        
        return view('admin.obat.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:30|unique:medicines,kode',
            'nama' => 'required|string|max:200',
            'nama_generik' => 'nullable|string|max:200',
            'kategori' => 'nullable|string|max:100',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'kontraindikasi' => 'nullable|string',
            'efek_samping' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            Medicine::create($validated);
            
            return redirect()->route('admin.obat.index')
                ->with('success', 'Obat berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        
        return view('admin.obat.edit', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);
        
        $validated = $request->validate([
            'kode' => 'required|string|max:30|unique:medicines,kode,' . $id,
            'nama' => 'required|string|max:200',
            'nama_generik' => 'nullable|string|max:200',
            'kategori' => 'nullable|string|max:100',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'kontraindikasi' => 'nullable|string',
            'efek_samping' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            $medicine->update($validated);
            
            return redirect()->route('admin.obat.index')
                ->with('success', 'Obat berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->delete();
            
            return redirect()->route('admin.obat.index')
                ->with('success', 'Obat berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
