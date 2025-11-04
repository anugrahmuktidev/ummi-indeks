<?php

namespace App\Livewire;

use App\Models\UserMeasurement;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MeasurementForm extends Component
{
    #[Validate('required|numeric|min:5|max:50')]
    public $lingkar_lengan;

    #[Validate('required|numeric|min:5|max:70')]
    public $panjang_lengan;

    public ?float $ratio = null;
    public ?string $riskMessage = null;
    public bool $showResult = false;
    public bool $canBypassToHome = false;

    public function mount(): void
    {
        $user = Auth::user();

        if ($latest = $user->latestMeasurement()->first()) {
            $this->lingkar_lengan = $latest->lingkar_lengan;
            $this->panjang_lengan = $latest->panjang_lengan;
            $this->ratio = $latest->ratio;
            $this->riskMessage = $latest->risk_status;
            $this->showResult = (bool) $latest->ratio;
        }

        $this->canBypassToHome = $user->has_completed_posttest || ! $user->is_first_login;
    }

    public function backHome(): void
    {
        if ($this->canBypassToHome) {
            $this->redirectRoute('home', navigate: true);
        }
    }

    public function save(): void
    {
        $user = Auth::user();
        $this->validate();

        $ratio = $this->calculateRatio();
        $riskMessage = $this->determineRiskMessage($ratio);

        UserMeasurement::updateOrCreate(
            ['user_id' => $user->id],
            [
                'lingkar_lengan' => $this->lingkar_lengan,
                'panjang_lengan' => $this->panjang_lengan,
                'ratio' => $ratio,
                'risk_status' => $riskMessage,
            ]
        );

        $user->forceFill(['has_submitted_measurement' => true])->save();

        $this->ratio = $ratio;
        $this->riskMessage = $riskMessage;
        $this->showResult = true;

        session()->flash('status', 'Data ukuran berhasil disimpan.');
    }

    public function proceed(): void
    {
        $this->redirectRoute('risk.form', navigate: true);
    }

    public function render()
    {
        return view('livewire.measurement-form')
            ->layout('layouts.basic');
    }

    protected function calculateRatio(): ?float
    {
        if ($this->panjang_lengan <= 0) {
            return null;
        }

        $ratio = $this->lingkar_lengan / sqrt($this->panjang_lengan);

        return round($ratio, 3);
    }

    protected function determineRiskMessage(?float $ratio): ?string
    {
        if ($ratio === null) {
            return null;
        }

        return $ratio >= 4.25
            ? 'Anda Tidak Berisiko KEK'
            : 'Anda Berisiko Tinggi KEK';
    }
}
