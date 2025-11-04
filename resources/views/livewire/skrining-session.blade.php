<div>
    @if ($totalQuestions === 0)
        <div class="alert alert-warning">Pertanyaan skrining belum tersedia.</div>
    @elseif ($showResult)
        <div class="card">
            <div class="card-body bg-success text-white text-center">
                <h3 class="fw-bold-text mb-0">Hasil Skrining</h3>
            </div>
            <div class="card-body text-center">
                <p class="fs-5">Status risiko Anda: <strong>{{ $statusRisiko }}</strong>.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
    @elseif ($question)
        <div class="card">
            <div class="bg-warning">
                <div class="card-body p-3 text-center">
                    <h3 class="fw-bold-text text-white mb-0">Skrining</h3>
                    <p class="mb-0 text-muted">Pertanyaan No {{ $currentIndex + 1 }} dari {{ $totalQuestions }}</p>
                </div>
            </div>
            <div class="card-body p-4">
                <h3>{{ $question->soal }}</h3>

                <div class="mt-3 ms-2">
                    @foreach ($question->jawaban as $option)
                        <div class="form-check form-radio-success mb-3">
                            <input id="answer-{{ $option->id }}" type="radio" class="form-check-input"
                                wire:model="selectedAnswer" value="{{ $option->id }}">
                            <label class="form-check-label" for="answer-{{ $option->id }}">
                                {{ $option->jawaban }}
                            </label>
                        </div>
                    @endforeach
                </div>

                @error('selectedAnswer')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror

                <div class="d-flex flex-column flex-md-row gap-2 justify-content-end mt-4">
                    @if ($currentIndex > 0)
                        <button type="button" wire:click="previous" class="btn btn-outline-danger w-100 w-md-auto"
                            wire:loading.attr="disabled">Sebelumnya</button>
                    @endif

                    <button type="button" wire:click="saveAndNext" class="btn btn-success w-100 w-md-auto"
                        wire:loading.attr="disabled">
                        {{ $currentIndex + 1 >= $totalQuestions ? 'Selesai' : 'Berikutnya' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
