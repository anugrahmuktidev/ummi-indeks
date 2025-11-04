@extends('layouts.basic')
@section('content')
    <style>
        @media (min-width: 768px) {
            .btn {
                max-width: 200px;
                /* Tentukan lebar maksimal untuk tombol di layar lebih besar */
            }
        }
    </style>
    <div>
        <div class="card">
            <div class="bg-warning">
                <div class="card-body p-3">
                    <div class="text-center">
                        <h3 class="fw-bold-text text-white">Pretest</h3>
                        <p class="mb-0 text-muted">Pertanyaan No {{ $currentQuestionNumber }} dari 10</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="question-container">
                    <h3>{{ $question->nomor_soal }}. {{ $question->soal }}</h3>
                </div>

                <form method="POST" action="{{ route('pretest.submit') }}">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <input type="hidden" name="question_number" value="{{ $currentQuestionNumber }}">

                    @foreach ($question->jawaban as $jawaban)
                        <div class="form-check form-radio-success mb-3 ms-4">
                            <input class="form-check-input" type="radio" name="jawaban_id" id="jawaban{{ $loop->index }}"
                                value="{{ $jawaban->id }}" {{ $previous == $jawaban->id ? 'checked' : '' }} required>
                            <label class="form-check-label" for="jawaban{{ $loop->index }}">
                                {{ $jawaban->jawaban }}
                            </label>
                        </div>
                    @endforeach

                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-end mt-4">

                        @if ($currentQuestionNumber > 1)
                            <a href="{{ route('pretest.show', ['questionNumber' => $currentQuestionNumber - 1]) }}"
                                class="btn btn-outline-danger material-shadow-none w-100 w-md-auto">Sebelumnya</a>
                        @endif
                        <button type="submit" id="nextButton" class="btn btn-success w-100 w-md-auto"
                            disabled>Berikutnya</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Mengambil semua radio button
            const radioButtons = document.querySelectorAll('input[name="jawaban_id"]');
            const nextButton = document.getElementById('nextButton');

            // Memantau jika ada radio button yang dipilih
            radioButtons.forEach(radio => {
                radio.addEventListener('change', () => {
                    if (radio.checked) {
                        nextButton.disabled = false; // Aktifkan tombol jika jawaban dipilih
                    }
                });
            });

            // Aktifkan tombol jika sudah ada jawaban yang dipilih (untuk kasus reload)
            if (Array.from(radioButtons).some(radio => radio.checked)) {
                nextButton.disabled = false;
            }
        </script>
    @endsection
