<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini (opsional, jika nama tabel tidak sesuai konvensi Laravel)
    protected $table = 'soal';

    // Primary key dari tabel (opsional, jika nama primary key tidak sesuai konvensi Laravel)
    protected $primaryKey = 'id';

    // Kolom-kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = ['soal', 'jenis_soal', 'nomor_soal'];

    public static function getNextNomorSoal($jenis_soal)
{
    return self::where('jenis_soal', $jenis_soal)
        ->max('nomor_soal') + 1;
}

    public static function reorderNomorSoal($jenis)
    {
        $soals = self::where('jenis_soal', $jenis)
            ->orderBy('nomor_soal')
            ->get();
        $nomor = 1;

        foreach ($soals as $soal) {
            $soal->nomor_soal = $nomor++;
            $soal->save();
        }
    }
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'soal_id');
    }


}

