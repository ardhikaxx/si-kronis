<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrescriptionTemplate;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionTemplateController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $templates = PrescriptionTemplate::with('doctor')
            ->when($user && $user->hasRole('dokter'), function($query) use ($user) {
                $query->where('doctor_id', $user->id);
            })
            ->latest()
            ->paginate(10);
        
        return view('admin.template-resep.index', compact('templates'));
    }

    public function create()
    {
        $medicines = Medicine::active()->get();
        return view('admin.template-resep.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.nama_obat' => 'required|string',
            'items.*.dosis' => 'required|string',
            'items.*.frekuensi' => 'required|string',
            'items.*.durasi' => 'required|string',
            'items.*.jumlah' => 'required|integer',
            'items.*.instruksi' => 'nullable|string',
        ]);

        PrescriptionTemplate::create([
            'doctor_id' => auth()->id(),
            'nama_template' => $request->nama_template,
            'deskripsi' => $request->deskripsi,
            'items' => $request->items,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.template-resep.index')
            ->with('success', 'Template resep berhasil dibuat');
    }

    public function edit(PrescriptionTemplate $template)
    {
        $medicines = Medicine::active()->get();
        return view('admin.template-resep.edit', compact('template', 'medicines'));
    }

    public function update(Request $request, PrescriptionTemplate $template)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.nama_obat' => 'required|string',
            'items.*.dosis' => 'required|string',
            'items.*.frekuensi' => 'required|string',
            'items.*.durasi' => 'required|string',
            'items.*.jumlah' => 'required|integer',
            'items.*.instruksi' => 'nullable|string',
        ]);

        $user = Auth::user();
        $template->update([
            'nama_template' => $request->nama_template,
            'deskripsi' => $request->deskripsi,
            'items' => $request->items,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.template-resep.index')
            ->with('success', 'Template resep berhasil diperbarui');
    }

    public function destroy(PrescriptionTemplate $template)
    {
        $template->delete();
        return redirect()->route('admin.template-resep.index')
            ->with('success', 'Template resep berhasil dihapus');
    }
}
