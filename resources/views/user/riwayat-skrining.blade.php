@extends('layouts.basic')

@section('content')
    <div class="card table-responsive table-card mb-4">
        <div class="card-header">
            <h3 class="fw-text-bold mb-0">Riwayat Penilaian Risiko KEK</h3>
        </div>
        <div class="justify-content-center p-4">
            <table class="table table-sm table-striped text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Probabilitas</th>
                        <th>Total Skor</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riskAssessments as $index => $assessment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ optional($assessment->created_at)->format('d-m-Y') }}<br>
                                <small>Jam: {{ optional($assessment->created_at)->format('H:i:s') }}</small>
                            </td>
                            <td>{{ number_format($assessment->probabilitas ?? 0, 2) }}%</td>
                            <td>{{ $assessment->total_skor ?? '-' }}</td>
                            <td>
                                @php
                                    $kategori = $assessment->kategori ?? 'Tidak ditentukan';
                                    $badgeClass = \Illuminate\Support\Str::contains($kategori, 'Tinggi')
                                        ? 'danger'
                                        : (\Illuminate\Support\Str::contains($kategori, 'Sedang') ? 'warning' : 'success');
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $kategori }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada riwayat penilaian risiko.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('home') }}" class="btn btn-outline-primary w-100 w-md-auto">
                    <i class="ri-home-4-line me-1"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

@endsection
