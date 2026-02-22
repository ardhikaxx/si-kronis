<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    use HasFactory;

    protected $table = 'doctor_profiles';

    protected $fillable = [
        'user_id',
        'nip',
        'str_number',
        'spesialisasi',
        'sub_spesialisasi',
        'pendidikan',
        'pengalaman_tahun',
        'biaya_konsultasi',
        'tentang',
        'rating',
        'total_konsultasi',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'biaya_konsultasi' => 'decimal:2',
            'rating' => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctorSchedules()
    {
        return $this->user()->hasMany(DoctorSchedule::class, 'doctor_id');
    }

    public function doctorLeaves()
    {
        return $this->user()->hasMany(DoctorLeave::class, 'doctor_id');
    }
}
