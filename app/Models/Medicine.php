<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $table = 'medicines';

    protected $fillable = [
        'kode',
        'nama',
        'nama_generik',
        'kategori',
        'satuan',
        'deskripsi',
        'kontraindikasi',
        'efek_samping',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
