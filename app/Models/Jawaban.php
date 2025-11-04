<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $table= 'jawaban';

    protected $fillable = ['soal_id', 'jawaban', 'kunci_jawaban', 'poin_soal'];

    public function soal()
    {
        return $this->belongsTo(Soal::class,'soal_id');
    }


}
