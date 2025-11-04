<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Soal;

class SoalCrud extends Component
{
    public $id, $soal, $jenis_soal, $filter = ''; // Variabel filter
    public $isOpen = false;
    public $nomor_soal;

    // public $filter='';

    protected $rules = [
        'soal' => 'required|string',
        'jenis_soal' => 'required|in:Pre Test,Post Test,Skrening',
    ];

    public function render()
    {
        // dd('test');
        $soals = $this->filter
            ? Soal::where('jenis_soal', $this->filter)->orderBy('nomor_soal')->get()
            : Soal::orderBy('jenis_soal')->orderBy('nomor_soal')->get();

        return view('livewire.soal-crud', [
            'soals' => $soals,
        ]);
    }





    public function create()
    {
        $this->resetInputFields();
        $this->nomor_soal = Soal::getNextNomorSoal($this->filter);
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        Soal::updateOrCreate(['id' => $this->id], [
            'soal' => $this->soal,
            'jenis_soal' => $this->jenis_soal,
            'nomor_soal' => $this->nomor_soal,
        ]);

        session()->flash('message', $this->id ? 'Soal updated successfully.' : 'Soal created successfully.');

        Soal::reorderNomorSoal($this->jenis_soal);
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        $this->id = $id;
        $this->soal = $soal->soal;
        $this->jenis_soal = $soal->jenis_soal;
        $this->nomor_soal = $soal->nomor_soal;
        $this->isOpen = true;
    }

    public function delete($id)
    {
        $soal = Soal::find($id);

        if ($soal) {
            $soal->jawaban()->delete();
            $soal->delete();
        }

        session()->flash('message', 'Soal deleted successfully.');

        Soal::reorderNomorSoal($soal->jenis_soal);
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->id = null;
        $this->soal = '';
        $this->jenis_soal = '';
        $this->nomor_soal = null;
    }
}
