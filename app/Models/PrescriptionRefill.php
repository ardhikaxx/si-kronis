<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionRefill extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'patient_id',
        'doctor_id',
        'catatan',
        'status',
        'response_note',
        'responded_by',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
        ];
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}
