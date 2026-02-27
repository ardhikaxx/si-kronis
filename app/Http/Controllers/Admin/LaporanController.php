<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConsultationsExport;
use App\Exports\PrescriptionsExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->toDateString());
        
        $stats = [
            'total_bookings' => Booking::whereBetween('tanggal_konsultasi', [$fromDate, $toDate])->count(),
            'completed_consultations' => Consultation::whereBetween('tanggal', [$fromDate, $toDate])
                ->where('status', 'completed')->count(),
            'total_prescriptions' => Prescription::whereBetween('tanggal_resep', [$fromDate, $toDate])->count(),
            'new_patients' => User::role('pasien')
                ->whereBetween('created_at', [$fromDate, $toDate])->count(),
        ];
        
        $bookingsByStatus = Booking::select('status', DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal_konsultasi', [$fromDate, $toDate])
            ->groupBy('status')
            ->get();
        
        $consultationsByDoctor = Consultation::select('doctor_id', DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$fromDate, $toDate])
            ->with('doctor')
            ->groupBy('doctor_id')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();
        
        $dailyBookings = Booking::select(
                DB::raw('DATE(tanggal_konsultasi) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('tanggal_konsultasi', [$fromDate, $toDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('admin.laporan.index', compact(
            'stats',
            'bookingsByStatus',
            'consultationsByDoctor',
            'dailyBookings',
            'fromDate',
            'toDate'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'consultations');
        $fromDate = $request->get('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->get('to_date', now()->toDateString());
        
        $filename = 'laporan_' . $type . '_' . date('Y-m-d');
        
        if ($type === 'consultations') {
            $data = Consultation::with(['patient', 'doctor'])
                ->whereBetween('tanggal', [$fromDate, $toDate])
                ->get()
                ->map(function ($consultation) {
                    return [
                        'Tanggal' => $consultation->tanggal->format('Y-m-d'),
                        'Pasien' => $consultation->patient->name ?? '-',
                        'Dokter' => $consultation->doctor->name ?? '-',
                        'Keluhan' => $consultation->anamnesis,
                        'Diagnosa' => $consultation->diagnosa,
                        'Tekanan Darah' => $consultation->tekanan_darah,
                        'Berat Badan' => $consultation->berat_badan,
                        'Gula Darah' => $consultation->gula_darah,
                        'Status' => $consultation->status,
                    ];
                });
            
            return Excel::download(new ConsultationsExport(), $filename . '.xlsx');
        }
        
        if ($type === 'prescriptions') {
            return Excel::download(new PrescriptionsExport(), $filename . '.xlsx');
        }
        
        if ($type === 'patients') {
            $patients = User::role('pasien')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->get()
                ->map(function ($patient) {
                    return [
                        'Nama' => $patient->name,
                        'Email' => $patient->email,
                        'Telepon' => $patient->phone ?? '-',
                        'Tanggal Daftar' => $patient->created_at->format('Y-m-d'),
                    ];
                });
            
            return Excel::download(new class($patients, ['Nama', 'Email', 'Telepon', 'Tanggal Daftar']) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
                private $data;
                private $headings;
                
                public function __construct($data, $headings) {
                    $this->data = $data;
                    $this->headings = $headings;
                }
                
                public function collection() {
                    return $this->data;
                }
                
                public function headings(): array {
                    return $this->headings;
                }
            }, $filename . '.xlsx');
        }
        
        return back()->with('error', 'Tipe export tidak valid.');
    }
}
