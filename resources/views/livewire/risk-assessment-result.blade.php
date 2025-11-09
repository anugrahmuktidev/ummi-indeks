<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold-text mb-3">Hasil Penilaian Risiko KEK</h3>
                <p class="text-muted">Berikut ringkasan probabilitas risiko berdasarkan jawaban yang telah Anda isi pada
                    formulir sebelumnya.</p>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @php
                    $probabilitasValue = $probabilitas ?? 0;
                    $totalSkorValue = $totalSkor ?? 0;
                    $kategoriLabel = $kategori ?? 'Risiko Rendah KEK';
                    $kategoriClass = $totalSkorValue >= 4 ? 'danger' : 'success';
                @endphp

                <div class="alert alert-{{ $kategoriClass }}">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold-text mb-1">Probabilitas Risiko</h5>
                            <p class="mb-1">Perkiraan kemungkinan mengalami KEK sebesar
                                <strong>{{ number_format($probabilitasValue, 2) }}%</strong>.</p>
                            <p class="mb-0">Dengan total skor <strong>{{ $totalSkorValue }}</strong>, Anda tergolong
                                <strong>{{ $kategoriLabel }}</strong>.</p>
                        </div>
                        <span class="badge bg-{{ $kategoriClass }} px-3 py-2 fw-bold-text">
                            {{ $kategoriLabel }}
                        </span>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <p class="text-muted mb-1">Probabilitas Risiko</p>
                            <h4 class="fw-bold-text mb-0">{{ number_format($probabilitasValue, 2) }}%</h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <p class="text-muted mb-1">Total Skor</p>
                            <h4 class="fw-bold-text mb-0">{{ $totalSkorValue }}</h4>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold-text mb-3">Detail Faktor Penilaian</h5>
                <div class="table-responsive mb-4">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Faktor</th>
                                <th>Jawaban</th>
                                <th class="text-center">Skor</th>
                                <th class="text-center">Probabilitas Faktor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factors as $factor)
                                <tr>
                                    <td>{{ $factor['label'] }}</td>
                                    <td>{{ $factor['selection'] }}</td>
                                    <td class="text-center">{{ $factor['score'] }}</td>
                                    <td class="text-center">{{ number_format($factor['probability'] ?? 0, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary w-100 w-md-auto" wire:click="redo">
                        <i class="ri-refresh-line me-1"></i>
                        Isi Ulang Penilaian
                    </button>
                    @if ($canProceedToPosttest)
                        <button type="button" class="btn btn-primary w-100 w-md-auto" wire:click="proceed">
                            <i class="ri-flight-takeoff-line me-1"></i>
                            Lanjut ke Posttest
                        </button>
                    @endif
                </div>

                @if ($showHomeButton)
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary w-100 w-md-auto">
                            <i class="ri-home-4-line me-1"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
