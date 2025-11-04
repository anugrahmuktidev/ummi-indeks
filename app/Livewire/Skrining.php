<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RiwayatSkrining;
use App\Models\User;
use App\Exports\SkriningExport;
use Maatwebsite\Excel\Facades\Excel;

class Skrining extends Component
{
    public $selectedUser = null;
    public $showModal = false;
    public function render()
    {
        $riwayatSkrining = RiwayatSkrining::with('user')->where('jenis_sesi', 'Skrining')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('livewire.skrining', [
            'riwayatSkrining' => $riwayatSkrining
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
    public function exportSkrining()
    {
        // Membuat nama file dengan format 'skrining-yyyy-mm-dd.xlsx'
        $fileName = 'Skrining-' . date('Y-m-d') . '.xlsx';

        // Mengunduh file dengan nama yang dinamis
        return Excel::download(new SkriningExport, $fileName);
    }
}
