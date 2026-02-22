<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientChronicCondition extends Model
{
    use HasFactory;

    protected $table = 'patient_chronic_conditions';

    protected $fillable = [
        'user_id',
        'chronic_category_id',
        'diagnosed_at',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'diagnosed_at' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chronicCategory()
    {
        return $this->belongsTo(ChronicCategory::class);
    }
}
