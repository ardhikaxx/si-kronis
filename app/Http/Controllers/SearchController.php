<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Medicine;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $role = auth()->user()->getRoleNames()->first();
        
        if (empty($query)) {
            return redirect()->back();
        }

        $results = [
            'patients' => collect(),
            'doctors' => collect(),
            'bookings' => collect(),
            'consultations' => collect(),
            'medicines' => collect(),
        ];

        // Search patients (users with role pasien)
        if ($role === 'admin') {
            $results['patients'] = User::role('pasien')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            $results['doctors'] = User::role('dokter')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            $results['bookings'] = Booking::whereHas('patient', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->orWhere('id', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            $results['consultations'] = Consultation::whereHas('patient', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->orWhere('anamnesis', 'like', "%{$query}%")
                ->orWhere('diagnosa', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            $results['medicines'] = Medicine::where('nama', 'like', "%{$query}%")
                ->orWhere('nama_generik', 'like', "%{$query}%")
                ->limit(10)
                ->get();
        }

        if ($role === 'dokter') {
            $userId = auth()->id();
            
            $results['patients'] = User::role('pasien')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            $results['consultations'] = Consultation::where('doctor_id', $userId)
                ->whereHas('patient', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->orWhere('anamnesis', 'like', "%{$query}%")
                ->orWhere('diagnosa', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            $results['bookings'] = Booking::where('doctor_id', $userId)
                ->whereHas('patient', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->limit(10)
                ->get();
        }

        if ($role === 'perawat') {
            $results['patients'] = User::role('pasien')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            $results['bookings'] = Booking::whereHas('patient', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->orWhere('id', 'like', "%{$query}%")
                ->limit(10)
                ->get();
        }

        $totalResults = $results['patients']->count() + $results['doctors']->count() + 
                       $results['bookings']->count() + $results['consultations']->count() + 
                       $results['medicines']->count();

        return view('search.index', compact('results', 'query', 'totalResults', 'role'));
    }
}
