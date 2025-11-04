<?php

namespace App\Livewire;

use App\Models\RiwayatSkrining;
use App\Models\Skrining;
use App\Models\Soal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PretestSession extends Component
{
    public array $questionIds = [];

    public int $currentIndex = 0;

    public ?int $selectedAnswer = null;

    public int $totalQuestions = 0;

    public bool $showResult = false;

    public int $totalCorrect = 0;

    public ?int $riwayatId = null;

    public function mount(): void
    {
        $this->questionIds = Soal::where('jenis_soal', 'Pre Test')
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
        return view('livewire.pretest-session', [
            'question' => $this->currentQuestion(),
        ])->layout('layouts.basic');
    }

    public function selectAnswer(int $answerId): void
    {
        $this->selectedAnswer = $answerId;
        $this->resetErrorBag('selectedAnswer');
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
        $this->resetErrorBag('selectedAnswer');
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

        if ($riwayat && $riwayat->status !== 'Completed') {
            $riwayat->update([
                'status' => 'Completed',
                'tanggal' => now(),
            ]);
        }

        $this->totalCorrect = Skrining::where('riwayat_skrining_id', $this->riwayatId)
            ->whereHas('jawaban', fn ($query) => $query->where('kunci_jawaban', true))
            ->count();

        $this->showResult = true;

        $user = Auth::user();
        if (! $user->has_completed_pretest) {
            $user->forceFill(['has_completed_pretest' => true])->save();
        }
    }

    protected function ensureActiveSession(): RiwayatSkrining
    {
        $user = Auth::user();

        $existing = RiwayatSkrining::where('user_id', $user->id)
            ->where('jenis_sesi', 'Pretest')
            ->where('status', 'In Progress')
            ->latest('tanggal')
            ->first();

        if ($existing) {
            return $existing;
        }

        return RiwayatSkrining::create([
            'user_id' => $user->id,
            'jenis_sesi' => 'Pretest',
            'tanggal' => now(),
            'status' => 'In Progress',
        ]);
    }
}
