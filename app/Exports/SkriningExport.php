<?php

namespace App\Exports;

use App\Models\UserRiskAssessment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkriningExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return UserRiskAssessment::with('user')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($riwayat) {
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
                    'probabilitas' => $riwayat->probabilitas,
                    'total_skor' => $riwayat->total_skor,
                    'kategori' => $riwayat->kategori,
                    'tanggal_penilaian' => $riwayat->created_at,
                    'umur' => $riwayat->umur,
                    'paritas' => $riwayat->paritas,
                    'kontrasepsi' => $riwayat->kontrasepsi,
                    'penyakit_infeksi' => $riwayat->penyakit_infeksi,
                    'aktifitas_fisik' => $riwayat->aktifitas_fisik,
                    'status_pekerjaan' => $riwayat->status_pekerjaan,
                    'status_kawin' => $riwayat->status_kawin,
                    'status_ekonomi' => $riwayat->status_ekonomi,

                ];
            });
    }

    public function headings(): array
    {
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
            'Probabilitas',
            'Total Skor',
            'Kategori',
            'Tanggal Penilaian',
            'Umur',
            'Paritas',
            'Kontrasepsi',
            'Penyakit Infeksi',
            'Aktivitas Fisik',
            'Status Pekerjaan',
            'Status Kawin',
            'Status Ekonomi',

        ];
    }
}
