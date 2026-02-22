<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['patient', 'doctor', 'chronicCategory']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['pending', 'confirmed']);
        }
        
        if ($request->filled('date')) {
            $query->whereDate('tanggal_konsultasi', $request->date);
        }
        
        $bookings = $query->orderBy('tanggal_konsultasi')
            ->orderBy('jam_mulai')
            ->paginate(15);
        
        return view('perawat.booking.index', compact('bookings'));
    }

    public function confirm(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            $booking->update([
                'status' => 'confirmed',
                'confirmed_by' => auth()->id(),
                'confirmed_at' => now(),
                'catatan_admin' => $validated['catatan_admin'] ?? null,
            ]);
            
            // TODO: Send notification to patient
            
            return back()->with('success', 'Booking berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $validated = $request->validate([
            'alasan_batal' => 'required|string|max:500',
        ]);

        try {
            $booking->update([
                'status' => 'cancelled',
                'cancelled_by' => auth()->id(),
                'cancelled_at' => now(),
                'alasan_batal' => $validated['alasan_batal'],
            ]);
            
            // TODO: Send notification to patient
            
            return back()->with('success', 'Booking berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
