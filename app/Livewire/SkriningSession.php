<?php

namespace App\Livewire;

use App\Models\RiwayatSkrining;
use App\Models\Skrining;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SkriningSession extends Component
{
    public array $questionIds = [];

    public int $currentIndex = 0;

    public ?int $selectedAnswer = null;

    public int $totalQuestions = 0;

    public bool $showResult = false;

    public ?string $statusRisiko = null;

    public ?int $riwayatId = null;

    public function mount(): void
    {
        $this->questionIds = Soal::where('jenis_soal', 'Skrining')
            ->orderBy('nomor_soal')
            ->pluck('id')
            ->all();

        $this->totalQuestions = count($this->questionIds);

        if ($this->totalQuestions === 0) {
            return;
        }

        $riwayat = $this->ensureActiveSession();
        $this->riwayatId = $riwayat->id;

        $answers = Skrining::where('riwayat_skrining_id', $this->riwayatId)
            ->whereIn('soal_id', $this->questionIds)
            ->get()
            ->keyBy('soal_id');

        if ($riwayat->status === 'Completed' && $answers->count()) {
            $this->finalizeSession();
            return;
        }

        foreach ($this->questionIds as $index => $questionId) {
            if (! $answers->has($questionId)) {
                $this->currentIndex = $index;
                break;
            }

            $this->currentIndex = min($index + 1, $this->totalQuestions - 1);
        }

        $this->loadSelectedAnswer();
    }

    public function render()
    {
        return view('livewire.skrining-session', [
            'question' => $this->currentQuestion(),
        ])->layout('layouts.basic');
    }

    public function selectAnswer(int $answerId): void
    {
        $this->selectedAnswer = $answerId;
    }

    public function saveAndNext(): void
    {
        if (! $this->selectedAnswer) {
            $this->addError('selectedAnswer', 'Silakan pilih salah satu jawaban.');
            return;
        }

        $questionId = $this->questionIds[$this->currentIndex] ?? null;
        if (! $questionId || ! $this->riwayatId) {
            return;
        }

        Skrining::updateOrCreate(
            [
                'riwayat_skrining_id' => $this->riwayatId,
                'soal_id' => $questionId,
            ],
            [
                'jawaban_id' => $this->selectedAnswer,
            ]
        );

        if ($this->currentIndex + 1 >= $this->totalQuestions) {
            $this->finalizeSession();
            return;
        }

        $this->currentIndex++;
        $this->loadSelectedAnswer();
    }

    public function previous(): void
    {
        if ($this->currentIndex === 0) {
            return;
        }

        $this->currentIndex--;
        $this->loadSelectedAnswer();
    }

    protected function loadSelectedAnswer(): void
    {
        $questionId = $this->questionIds[$this->currentIndex] ?? null;
        if (! $questionId || ! $this->riwayatId) {
            $this->selectedAnswer = null;
            return;
        }

        $existing = Skrining::where('riwayat_skrining_id', $this->riwayatId)
            ->where('soal_id', $questionId)
            ->first();

        $this->selectedAnswer = $existing?->jawaban_id;
    }

    protected function currentQuestion(): ?Soal
    {
        $questionId = $this->questionIds[$this->currentIndex] ?? null;

        return $questionId
            ? Soal::with('jawaban')->find($questionId)
            : null;
    }

    protected function finalizeSession(): void
    {
        if (! $this->riwayatId) {
            return;
        }

        $riwayat = RiwayatSkrining::find($this->riwayatId);
        if (! $riwayat) {
            return;
        }

        $answers = Skrining::where('riwayat_skrining_id', $riwayat->id)
            ->whereIn('soal_id', $this->questionIds)
            ->with(['jawaban', 'soal'])
            ->get();

        $jawabanNomor1 = false;
        $jawabanNomor2 = false;

        foreach ($answers as $jawaban) {
            if ($jawaban->soal->nomor_soal == 1 && $jawaban->jawaban?->kunci_jawaban) {
                $jawabanNomor1 = true;
            }
            if ($jawaban->soal->nomor_soal == 2 && $jawaban->jawaban?->kunci_jawaban) {
                $jawabanNomor2 = true;
            }
        }

        $status = 'Rendah';
        if ($jawabanNomor1 && $jawabanNomor2) {
            $status = 'Tinggi';
        } elseif ($jawabanNomor1 && ! $jawabanNomor2) {
            $status = 'Sedang';
        }

        if ($riwayat->status !== 'Completed') {
            $riwayat->update([
                'status' => 'Completed',
                'status_risiko' => $status,
                'tanggal' => now(),
            ]);
        } else {
            $riwayat->update(['status_risiko' => $status]);
        }

        $user = Auth::user();
        if ($user instanceof User && $user->is_first_login) {
            $user->is_first_login = false;
            $user->save();
        }

        $this->statusRisiko = $status;
        $this->showResult = true;
    }

    protected function ensureActiveSession(): RiwayatSkrining
    {
        $user = Auth::user();

        $existing = RiwayatSkrining::where('user_id', $user->id)
            ->where('jenis_sesi', 'Skrining')
            ->where('status', 'In Progress')
            ->latest('tanggal')
            ->first();

        if ($existing) {
            return $existing;
        }

        return RiwayatSkrining::create([
            'user_id' => $user->id,
            'jenis_sesi' => 'Skrining',
            'tanggal' => now(),
            'status' => 'In Progress',
        ]);
    }
}
