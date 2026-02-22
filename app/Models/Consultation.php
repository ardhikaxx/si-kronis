<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $table = 'consultations';

    protected $fillable = [
        'booking_id',
        'patient_id',
        'doctor_id',
        'tanggal',
        'mulai_at',
        'selesai_at',
        'anamnesis',
        'pemeriksaan_fisik',
        'tekanan_darah',
        'berat_badan',
        'tinggi_badan',
        'suhu_tubuh',
        'saturasi_o2',
        'gula_darah',
        'diagnosa',
        'icd_code',
        'rencana_terapi',
        'saran_dokter',
        'tindak_lanjut',
        'tanggal_kontrol',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'mulai_at' => 'datetime',
            'selesai_at' => 'datetime',
            'tanggal_kontrol' => 'date',
            'berat_badan' => 'decimal:2',
            'tinggi_badan' => 'decimal:2',
            'suhu_tubuh' => 'decimal:1',
            'gula_darah' => 'decimal:2',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function labResults()
    {
        return $this->hasMany(LabResult::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
