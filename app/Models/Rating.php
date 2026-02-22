<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';

    protected $fillable = [
        'consultation_id',
        'patient_id',
        'doctor_id',
        'skor',
        'ulasan',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function scopeExcellent($query)
    {
        return $query->where('skor', 5);
    }

    public function scopeGood($query)
    {
        return $query->where('skor', '>=', 4);
    }

    public function scopePoor($query)
    {
        return $query->where('skor', '<', 3);
    }
}
