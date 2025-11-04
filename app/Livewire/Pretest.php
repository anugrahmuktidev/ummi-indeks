<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Skrining;
use App\Models\RiwayatSkrining;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PretestExport;

class Pretest extends Component
{
    public $selectedUser = null;
    public $showModal = false;
    public function render()
    {
        // Ambil semua user
        $users = User::all();

        // Array untuk menyimpan hasil pretest setiap user
        $pretestResults = [];

        foreach ($users as $user) {
            // Ambil data riwayat pretest terbaru dari setiap user
            $riwayatPretest = RiwayatSkrining::where('user_id', $user->id)
                ->where('jenis_sesi', 'Pretest')
                ->where('status', 'Completed')
                ->latest('tanggal')
                ->first();

            if ($riwayatPretest) {
                // Hitung total jawaban benar untuk pretest user ini
                $totalBenar = Skrining::where('riwayat_skrining_id', $riwayatPretest->id)
                    ->whereHas('jawaban', function ($query) {
                        $query->where('kunci_jawaban', true); // Jawaban yang benar
                    })
                    ->count();

                // Simpan hasil pretest user ini
                $pretestResults[] = [
                    'user' => $user->name,      // Nama user
                    'totalBenar' => $totalBenar, // Jawaban benar
                ];
            }
        }

        // Tampilkan hasil untuk admin
        return view('livewire.pretest', [
            'pretestResults' => $pretestResults
        ]);

    }

    public function viewUserBiodata($userId)
    {
        // Mendapatkan data user
        $this->selectedUser = User::findOrFail($userId);
        // Memunculkan modal
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedUser = null;
    }
    public function exportPretest()
    {
        // Membuat nama file dengan format pretest-yyyy-mm-dd.xlsx
        $fileName = 'pretest-' . date('Y-m-d') . '.xlsx';

        // Mengunduh file Pretest
        return Excel::download(new PretestExport(), $fileName);
    }
}
