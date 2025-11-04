<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Jawaban;
use App\Models\Soal;

class JawabanCrud extends Component
{
    public $jawaban_id, $soal_id, $jawaban, $kunci_jawaban = false, $poin_soal;
    public $soals, $jawabans;
    public $isOpen = false;
    public $filter = ''; // Inisialisasi dengan string kosong


    public function mount()
    {
        $this->soals = collect();
        $this->jawabans = collect();
    }

    public function render()
    {
        $this->soals = $this->filter
        ? Soal::where('jenis_soal', $this->filter)->get()
        : Soal::all();

    $this->jawabans = $this->filter
        ? Jawaban::whereIn('soal_id', $this->soals->pluck('id'))->get()
        : Jawaban::all();

        return view('livewire.jawaban-crud', [
            'soals' => $this->soals,
            'jawabans' => $this->jawabans,
        ]);
    }

    // public function applyFilter()
    // {

    // }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->jawaban_id = '';
        $this->soal_id = '';
        $this->jawaban = '';
        $this->kunci_jawaban = false;
        $this->poin_soal = '';
    }

    public function store()
    {
        $this->validate([
            'soal_id' => 'required',
            'jawaban' => 'required',
            'kunci_jawaban' => 'boolean',
            'poin_soal' => 'required|integer',
        ]);

        if ($this->kunci_jawaban) {
            Jawaban::where('soal_id', $this->soal_id)
                ->update(['kunci_jawaban' => false]);
        }

        Jawaban::updateOrCreate(['id' => $this->jawaban_id], [
            'soal_id' => $this->soal_id,
            'jawaban' => $this->jawaban,
            'kunci_jawaban' => $this->kunci_jawaban,
            'poin_soal' => $this->poin_soal,
        ]);

        session()->flash('message', $this->jawaban_id ? 'Jawaban Updated Successfully.' : 'Jawaban Created Successfully.');

        $this->closeModal();

    }

    public function edit($id)
    {
        $jawaban = Jawaban::findOrFail($id);
        $this->jawaban_id = $id;
        $this->soal_id = $jawaban->soal_id;
        $this->jawaban = $jawaban->jawaban;
        $this->kunci_jawaban = $jawaban->kunci_jawaban;
        $this->poin_soal = $jawaban->poin_soal;

        $this->openModal();
    }

    public function delete($id)
    {
        Jawaban::find($id)->delete();
        session()->flash('message', 'Jawaban Deleted Successfully.');
        //  $this->applyFilter();
    }
}
