<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRiskAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'probabilitas',
        'kategori',
        'catatan',
        'total_skor',
        'umur',
        'paritas',
        'kontrasepsi',
        'penyakit_infeksi',
        'aktifitas_fisik',
        'status_pekerjaan',
        'status_kawin',
        'status_ekonomi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
