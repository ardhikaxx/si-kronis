<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'kode_booking',
        'patient_id',
        'doctor_id',
        'tanggal_konsultasi',
        'jam_mulai',
        'jam_selesai',
        'keluhan',
        'chronic_category_id',
        'tipe_konsultasi',
        'status',
        'catatan_pasien',
        'catatan_admin',
        'confirmed_by',
        'confirmed_at',
        'cancelled_by',
        'cancelled_at',
        'alasan_batal',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_konsultasi' => 'date',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function chronicCategory()
    {
        return $this->belongsTo(ChronicCategory::class);
    }

    public function consultation()
    {
        return $this->hasOne(Consultation::class);
    }

    public function labResults()
    {
        return $this->hasMany(LabResult::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_konsultasi', '>=', now()->toDateString())
            ->where('status', '!=', 'cancelled');
    }

    public function scopePast($query)
    {
        return $query->where('tanggal_konsultasi', '<', now()->toDateString());
    }
}
