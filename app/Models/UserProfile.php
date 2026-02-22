<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'bpjs_number',
        'emergency_contact',
        'emergency_phone',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patientChronicConditions()
    {
        return $this->user()->hasMany(PatientChronicCondition::class, 'user_id');
    }

    public function labResults()
    {
        return $this->user()->hasMany(LabResult::class, 'patient_id');
    }
}
