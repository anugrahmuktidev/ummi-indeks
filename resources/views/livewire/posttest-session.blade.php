<div>
    @if ($totalQuestions === 0)
        <div class="alert alert-warning">Soal posttest belum tersedia.</div>
    @elseif ($showResult)
        <div class="card">
            <div class="card-body bg-success text-white">
                <h3 class="text-center fw-bold-text mb-0">Hasil Posttest</h3>
            </div>
            <div class="card-body text-center">
                <p class="fs-5">Jawaban benar: <strong>{{ $totalCorrect }}</strong> dari {{ $totalQuestions }} soal.</p>
                <p class="mb-4">Jumlah materi edukasi yang disimak: <strong>{{ $watchCountLabel ?? '-' }}</strong></p>
                <a href="{{ route('home') }}" class="btn btn-primary"><i class="ri-home-4-line me-1"></i>Kembali ke Beranda</a>
            </div>
        </div>
    @elseif ($needsWatchCount)
        <div class="card">
            <div class="card-body bg-warning text-center">
                <h3 class="fw-bold-text mb-0">Posttest</h3>
            </div>
            <div class="card-body">
                <h5 class="text-center mb-4">Berapa kali Anda mengikuti materi edukasi KEK sebelumnya?</h5>
                <div class="ms-3">
                    @foreach ($watchOptions as $optionValue => $optionLabel)
                        <div class="form-check form-radio-success mb-2">
                            <input type="radio" id="watch-{{ $optionValue }}" class="form-check-input" wire:model="watchCount"
                                value="{{ $optionValue }}">
                            <label class="form-check-label" for="watch-{{ $optionValue }}">{{ $optionLabel }}</label>
                        </div>
                    @endforeach
                </div>
                @error('watchCount')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-primary" wire:click="submitWatchCount"
                        wire:loading.attr="disabled" wire:target="submitWatchCount">
                        <i class="ri-flight-takeoff-line me-1"></i>Mulai Posttest
                    </button>
                </div>
            </div>
        </div>
    @elseif ($question)
        <div class="card">
            <div class="bg-warning">
                <div class="card-body p-3 text-center">
                    <h3 class="fw-bold-text text-white mb-0">Posttest</h3>
                    <p class="mb-0 text-muted">Pertanyaan No {{ $currentIndex + 1 }} dari {{ $totalQuestions }}</p>
                </div>
            </div>
            <div class="card-body p-4">
                <h3>{{ $question->nomor_soal }}. {{ $question->soal }}</h3>

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
                            wire:loading.attr="disabled"><i class="ri-arrow-left-line me-1"></i>Sebelumnya</button>
                    @endif

                    <button type="button" wire:click="saveAndNext" class="btn btn-success w-100 w-md-auto"
                        wire:loading.attr="disabled">
                        <i class="ri-check-line me-1"></i>
                        {{ $currentIndex + 1 >= $totalQuestions ? 'Selesai' : 'Berikutnya' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
