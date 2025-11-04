<?php

namespace App\Exports;

use App\Models\RiwayatSkrining;
use App\Models\Skrining;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PretestExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Mengambil data riwayat skrining dengan jenis sesi 'Pretest' dan status 'completed'
        $riwayatPretest = RiwayatSkrining::with(['user', 'skrining'])
            ->where('jenis_sesi', 'Pretest')
            ->where('status', 'Completed') // Pastikan hanya yang berstatus 'completed'
            ->orderBy('tanggal', 'desc')
            ->get();

        // Memetakan data untuk keperluan ekspor
        return $riwayatPretest->map(function ($riwayat) {
            // Mendapatkan semua soal yang terkait dengan riwayat skrining ini
            $soals = Skrining::where('riwayat_skrining_id', $riwayat->id)->get();
            $jawabanBenar = [];

            // Pastikan ada soal sebelum mengisi hasil
            if ($soals->isNotEmpty()) {
                // Mengisi hasil untuk setiap soal
                foreach ($soals as $soal) {
                    // Menyimpan hasil jawaban: 'Benar' jika kunci jawaban benar, 'Salah' jika tidak
                    $jawabanBenar[] = $soal->jawaban->kunci_jawaban ? 'B' : 'S';
                }
            } else {
                // Jika tidak ada soal, isi jawabanBenar dengan nilai default
                $jawabanBenar = array_fill(0, 10, 'S'); // Mengisi dengan 'Salah' untuk 10 soal
            }

            return [
                'nama_user' => $riwayat->user->name,
                'no_hp' => $riwayat->user->no_hp,
                'tanggal_lahir' => $riwayat->user->tanggal_lahir,
                'jenis_kelamin' => $riwayat->user->jenis_kelamin,
                'pendidikan' => $riwayat->user->pendidikan,
                'pekerjaan' => $riwayat->user->pekerjaan == 'Lainnya'
                ? $riwayat->user->pekerjaan_lain
                : $riwayat->user->pekerjaan,
                'alamat' => $riwayat->user->alamat,
                'no_rumah' => $riwayat->user->no_rumah,
                'rt' => $riwayat->user->rt,
                'kelurahan' => $riwayat->user->kelurahan,
                'kecamatan' => $riwayat->user->kecamatan,
                'kabupaten' => $riwayat->user->kabupaten,
                'provinsi' => $riwayat->user->provinsi,
                'berat_badan' => $riwayat->user->berat_badan,
                'tinggi_badan' => $riwayat->user->tinggi_badan,
                'total_soal' => $soals->count(),
                'tanggal_skrining' => $riwayat->tanggal,
                // Menambahkan hasil jawaban untuk setiap soal P1 - P10
                'P1' => $jawabanBenar[0] ?? 'S',
                'P2' => $jawabanBenar[1] ?? 'S',
                'P3' => $jawabanBenar[2] ?? 'S',
                'P4' => $jawabanBenar[3] ?? 'S',
                'P5' => $jawabanBenar[4] ?? 'S',
                'P6' => $jawabanBenar[5] ?? 'S',
                'P7' => $jawabanBenar[6] ?? 'S',
                'P8' => $jawabanBenar[7] ?? 'S',
                'P9' => $jawabanBenar[8] ?? 'S',
                'P10' => $jawabanBenar[9] ?? 'S',
                'total_benar' => array_count_values($jawabanBenar)['B'] ?? 0,

            ];
        });
    }

    public function headings(): array
    {
        // Menentukan kolom yang akan menjadi header di file Excel
        return [
            'Nama User',
            'No HP',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Pendidikan',
            'Pekerjaan',
            'Alamat',
            'No Rumah',
            'RT',
            'Kelurahan',
            'Kecamatan',
            'Kabupaten',
            'Provinsi',
            'Berat Badan',
            'Tinggi Badan',
            'Total Soal Dikerjakan',
            'Tanggal Pretest',
            'P1',
            'P2',
            'P3',
            'P4',
            'P5',
            'P6',
            'P7',
            'P8',
            'P9',
            'P10',
            'Total Soal Benar',

        ];
    }
}
