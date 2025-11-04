<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold-text mb-4">Pengukuran Lingkar & Panjang Lengan Atas(LiLA)</h3>
                <p class="text-muted">Isi data berikut untuk memantau status gizi Anda. Gunakan pita LiLA atau meteran
                    yang
                    akurat, kemudian masukkan hasil pengukuran dalam sentimeter.</p>
                <div class="mt-4">
                    <div class="row g-3">
                        @foreach ([1, 2, 3] as $index)
                            <div class="col-12 col-md-4">
                                <div class="ratio ratio-4x3 rounded overflow-hidden shadow-sm border border-light-subtle">
                                    <img src="{{ asset('assets/img/kek' . $index . '.jpg') }}" class="object-fit-cover w-100 h-100"
                                        alt="Panduan LiLA {{ $index }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form wire:submit.prevent="save" class="vstack gap-3">
                    <div>
                        <label class="form-label">Lingkar Lengan Atas (cm)</label>
                        <input type="number" step="0.1" min="5" max="50" class="form-control"
                            wire:model.defer="lingkar_lengan">
                        @error('lingkar_lengan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Panjang Lengan Atas (cm)</label>
                        <input type="number" step="0.1" min="5" max="70" class="form-control"
                            wire:model.defer="panjang_lengan">
                        @error('panjang_lengan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        @if ($canBypassToHome)
                            <button type="button" class="btn btn-outline-secondary" wire:click="backHome">
                                <i class="ri-home-4-line me-1"></i>
                                Kembali ke Beranda
                            </button>
                        @else
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="ri-arrow-go-back-line me-1"></i>
                                Batal
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <i class="ri-calculator-line me-1"></i>
                            Hitung Risiko
                        </button>
                    </div>
                </form>

                @if ($showResult)
                    <hr class="my-4">
                    <div class="alert {{ $ratio >= 4.25 ? 'alert-success' : 'alert-danger' }}">
                        <h5 class="fw-bold-text mb-2">Hasil Perhitungan</h5>
                        <p class="mb-1">Nilai LILA / √PLA = <strong>{{ number_format($ratio ?? 0, 3) }}</strong></p>
                        <p class="mb-3 fw-bold-text">{{ $riskMessage }}</p>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-success" wire:click="proceed">
                                <i class="ri-arrow-right-line me-1"></i>
                                Lanjut ke Penilaian Risiko KEK
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
