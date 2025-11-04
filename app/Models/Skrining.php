<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skrining extends Model
{
    use HasFactory;
    protected $fillable = ['soal_id', 'jawaban_id', 'riwayat_skrining_id'];
    protected  $table = 'skrining';

       public function soal()
    {
        return $this->belongsTo(Soal::class);
    }


    public function riwayatSkrining()
    {
        return $this->belongsTo(RiwayatSkrining::class, 'riwayat_skrining_id');
    }

    public function jawaban()
{
    return $this->belongsTo(Jawaban::class, 'jawaban_id');
}
}
