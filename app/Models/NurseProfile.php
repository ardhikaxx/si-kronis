<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseProfile extends Model
{
    use HasFactory;

    protected $table = 'nurse_profiles';

    protected $fillable = [
        'user_id',
        'nip',
        'str_number',
        'spesialisasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
