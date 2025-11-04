<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSkrining extends Model
{
    use HasFactory;
    protected $table = 'riwayat_skrining';
    protected $fillable = ['user_id', 'tanggal', 'status' ,'status_risiko', 'jenis_sesi','jumlah_edukasi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function jawabans()
    {
        return $this->hasMany(Skrining::class, 'riwayat_skrining_id');
    }

    public function skrining()
{
    return $this->hasMany(Skrining::class);
}


}
