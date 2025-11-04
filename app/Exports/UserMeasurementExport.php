<?php

namespace App\Exports;

use App\Models\UserMeasurement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserMeasurementExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return UserMeasurement::with('user')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($measurement) {
                $user = $measurement->user;

                return [
                    'nama_user' => $user?->name,
                    'no_hp' => $user?->no_hp,
                    'tanggal_lahir' => $user?->tanggal_lahir,
                    'jenis_kelamin' => $user?->jenis_kelamin,
                    'pendidikan' => $user?->pendidikan,
                    'pekerjaan' => $user?->pekerjaan === 'Lainnya' ? $user?->pekerjaan_lain : ($user?->pekerjaan),
                    'alamat' => $user?->alamat,
                    'no_rumah' => $user?->no_rumah,
                    'rt' => $user?->rt,
                    'kelurahan' => $user?->kelurahan,
                    'kecamatan' => $user?->kecamatan,
                    'kabupaten' => $user?->kabupaten,
                    'provinsi' => $user?->provinsi,
                    'berat_badan' => $user?->berat_badan,
                    'tinggi_badan' => $user?->tinggi_badan,
                    'lingkar_lengan' => $measurement->lingkar_lengan,
                    'panjang_lengan' => $measurement->panjang_lengan,
                    'ratio' => $measurement->ratio,
                    'status_risiko' => $measurement->risk_status,
                    'tanggal_pengukuran' => $measurement->created_at,
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
            'Lingkar Lengan (cm)',
            'Panjang Lengan (cm)',
            'Rasio',
            'Status Risiko',
            'Tanggal Pengukuran',
        ];
    }
}

