<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
    use HasFactory;

    protected $table = 'lab_results';

    protected $fillable = [
        'patient_id',
        'booking_id',
        'consultation_id',
        'nama_lab',
        'tanggal_lab',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'catatan',
        'is_reviewed',
        'reviewed_by',
        'reviewed_at',
        'catatan_review',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lab' => 'date',
            'is_reviewed' => 'boolean',
            'reviewed_at' => 'datetime',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function scopeReviewed($query)
    {
        return $query->where('is_reviewed', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_reviewed', false);
    }
}
