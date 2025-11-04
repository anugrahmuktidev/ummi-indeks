<?php

namespace App\Livewire;

use App\Models\RiwayatSkrining;
use App\Models\Skrining;
use App\Models\Soal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PosttestSession extends Component
{
    private const WATCH_COUNT_OPTIONS = [
        '1' => '1 kali',
        '2' => '2 kali',
        '3' => '3 kali',
        'lebih_dari_3' => 'Lebih dari 3 kali',
    ];

    public array $questionIds = [];

    public int $currentIndex = 0;

    public ?int $selectedAnswer = null;

    public int $totalQuestions = 0;

    public bool $showResult = false;

    public int $totalCorrect = 0;

    public ?int $riwayatId = null;

    public ?string $watchCount = null;

    public bool $needsWatchCount = true;

    public function mount(): void
    {
        $this->questionIds = Soal::where('jenis_soal', 'Post Test')
            ->orderBy('nomor_soal')
            ->pluck('id')
            ->all();

        $this->totalQuestions = count($this->questionIds);

        if ($this->totalQuestions === 0) {
            return;
        }

        $riwayat = $this->ensureActiveSession();
        $this->riwayatId = $riwayat->id;

        if ($riwayat->jumlah_edukasi) {
            $this->needsWatchCount = false;
            $this->watchCount = $this->resolveWatchCountKey($riwayat->jumlah_edukasi);
        }

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
        return view('livewire.posttest-session', [
            'question' => $this->currentQuestion(),
            'watchOptions' => self::WATCH_COUNT_OPTIONS,
            'watchCountLabel' => $this->watchCountLabel(),
        ])->layout('layouts.basic');
    }

    public function selectAnswer(int $answerId): void
    {
        $this->selectedAnswer = $answerId;
        $this->resetErrorBag('selectedAnswer');
    }

    public function submitWatchCount(): void
    {
        if (! $this->watchCount) {
            $this->addError('watchCount', 'Silakan pilih salah satu opsi.');
            return;
        }

        if (! $this->riwayatId) {
            return;
        }

        RiwayatSkrining::where('id', $this->riwayatId)->update([
            'jumlah_edukasi' => $this->watchCountLabel() ?? $this->watchCount,
        ]);

        $this->needsWatchCount = false;
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
        if ($this->needsWatchCount) {
            return null;
        }

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
        $updates = [];

        if ($user->is_first_login) {
            $updates['is_first_login'] = false;
        }

        if (! $user->has_completed_posttest) {
            $updates['has_completed_posttest'] = true;
        }

        if (! empty($updates)) {
            $user->forceFill($updates)->save();
        }
    }

    protected function ensureActiveSession(): RiwayatSkrining
    {
        $user = Auth::user();

        $existing = RiwayatSkrining::where('user_id', $user->id)
            ->where('jenis_sesi', 'Post Test')
            ->where('status', 'In Progress')
            ->latest('tanggal')
            ->first();

        if ($existing) {
            return $existing;
        }

        return RiwayatSkrining::create([
            'user_id' => $user->id,
            'jenis_sesi' => 'Post Test',
            'tanggal' => now(),
            'status' => 'In Progress',
        ]);
    }

    protected function watchCountLabel(): ?string
    {
        if (! $this->watchCount) {
            return null;
        }

        return self::WATCH_COUNT_OPTIONS[$this->watchCount] ?? $this->watchCount;
    }

    protected function resolveWatchCountKey(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (isset(self::WATCH_COUNT_OPTIONS[$value])) {
            return $value;
        }

        $reverse = array_flip(self::WATCH_COUNT_OPTIONS);

        return $reverse[$value] ?? $value;
    }
}
