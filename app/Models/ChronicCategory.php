<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChronicCategory extends Model
{
    use HasFactory;

    protected $table = 'chronic_categories';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'icon',
        'warna',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function patientChronicConditions()
    {
        return $this->hasMany(PatientChronicCondition::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
