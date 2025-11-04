<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Skrining;
use App\Models\RiwayatSkrining;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PosttestExport;

class Posttest extends Component
{   public $selectedUser = null;
    public $showModal = false;
    public function render()
    {
         // Ambil semua user
         $users = User::all();

         // Array untuk menyimpan hasil pretest setiap user
         $posttestResult = [];

         foreach ($users as $user) {
             // Ambil data riwayat pretest terbaru dari setiap user
             $riwayatPretest = RiwayatSkrining::where('user_id', $user->id)
                 ->where('jenis_sesi', 'Post Test')
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
                 $posttestResult[] = [
                     'user' => $user->name,      // Nama user
                     'totalBenar' => $totalBenar, // Jawaban benar
                 ];
             }
         }
        return view('livewire.posttest',[
            'posttestResult' => $posttestResult
        ]);
    }
    public function exportPosttest()
    {
        // Membuat nama file dengan format posttest-yyyy-mm-dd.xlsx
        $fileName = 'posttest-' . date('Y-m-d') . '.xlsx';

        // Mengunduh file Posttest
        return Excel::download(new PosttestExport(), $fileName);
    }
}
