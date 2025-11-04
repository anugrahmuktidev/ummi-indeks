@extends('layouts.basic')

@section('content')
    <style>
        @media (max-width: 576px) {
            .card {
                width: 100%;
                /* Buat kartu memenuhi lebar layar di perangkat mobile */
                margin: 10px auto;
                /* Tambahkan margin kecil untuk pemisahan */
            }

            .card-body {
                padding: 15px;
                /* Tambahkan padding yang nyaman di dalam kartu */
            }

            .badge {
                font-size: 0.85rem;
                /* Kurangi ukuran badge agar sesuai */
                padding: 5px 10px;
                /* Sesuaikan padding badge */
            }

            ol.ms-3 {
                margin-left: 0 !important;
                /* Hilangkan margin untuk tampilan lebih rata */
                padding-left: 1.2rem;
                /* Beri sedikit padding agar teks tetap terbaca */
            }

            .text-end {
                text-align: center;
                /* Atur tombol ke tengah pada perangkat kecil */
                margin-top: 10px;
            }

            .btn {
                width: 100%;
                /* Buat tombol lebar penuh di perangkat kecil */
                font-size: 0.9rem;
                /* Sesuaikan ukuran font tombol */
            }
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 p-2">
            @if ($statusRisiko === 'Rendah')
                <div class="card border card-border-success">
                    <div class="card-header bg-success text-white">
                        <h6 class="card-title mb-0 text-center text-white">HASIL PREDIKSI RISIKO KEK</h6>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-success align-middle fs-6 my-3 d-block text-center text-wrap"
                            style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-width: 100%;">ANDA
                            TERMASUK KATEGORI RISIKO RENDAH KEK</span>
                        <p class="card-text">Rekomendasi tindak lanjut:</p>
                        <ol class="ms-3">
                            <li>Pertahankan pola makan bergizi seimbang dengan sumber karbohidrat, protein, dan sayur/buah.</li>
                            <li>Lakukan pemantauan berat badan dan LILA secara berkala (misal setiap bulan).</li>
                            <li>Teruskan aktivitas fisik dan istirahat cukup untuk menjaga keseimbangan energi.</li>
                            <li>Konsultasikan perubahan pola makan bila mengalami penurunan nafsu makan atau berat badan.</li>
                        </ol>
                        <div class="text-end">
                            <a href="{{ route('home') }}" class="btn btn-outline-success"><i class="ri-home-4-line me-1"></i>Tutup</a>
                        </div>
                    </div>
                </div>
            @elseif ($statusRisiko === 'Sedang')
                <div class="card border card-border-warning">
                    <div class="card-header bg-warning text-white">
                        <h6 class="card-title mb-0 text-center text-white">HASIL PREDIKSI RISIKO KEK</h6>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-warning align-middle fs-6 my-3 d-block text-center text-wrap"
                            style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-width: 100%;">ANDA
                            TERMASUK KATEGORI RISIKO SEDANG KEK</span>
                        <p class="card-text">Rekomendasi tindak lanjut:</p>
                        <ol class="ms-3">
                            <li>Konsultasikan pola makan dengan tenaga gizi di fasilitas kesehatan terdekat.</li>
                            <li>Tingkatkan asupan energi dengan menambah frekuensi makan dan camilan bergizi.</li>
                            <li>Catat menu harian dan lakukan penimbangan berat badan serta LILA minimal setiap dua minggu.</li>
                            <li>Perhatikan gejala seperti cepat lelah atau penurunan berat badan; segera lakukan pemeriksaan bila berlanjut.</li>
                        </ol>
                        <div class="text-end">
                            <a href="{{ route('home') }}" class="btn btn-outline-warning"><i class="ri-home-4-line me-1"></i>Tutup</a>
                        </div>
                    </div>
                </div>
            @elseif ($statusRisiko === 'Tinggi')
                <div class="card border card-border-danger">
                    <div class="card-header bg-danger text-white">
                        <h6 class="card-title mb-0 text-center text-white">HASIL PREDIKSI RISIKO KEK</h6>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-danger align-middle fs-6 my-3 d-block text-center text-wrap"
                            style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-width: 100%;">ANDA
                            TERMASUK KATEGORI RISIKO TINGGI KEK</span>
                        <p class="card-text">Rekomendasi tindak lanjut:</p>
                        <ol class="ms-3">
                            <li>Sangat dianjurkan segera ke fasilitas kesehatan untuk pemeriksaan gizi menyeluruh dan
                                intervensi lebih lanjut.</li>
                            <li>Dapatkan suplemen atau makanan tambahan sesuai anjuran tenaga kesehatan.</li>
                            <li>Monitor berat badan, LILA, dan gejala klinis (mis. mudah lemas, pusing, penurunan nafsu makan) setiap minggu.</li>
                            <li>Libatkan keluarga atau pendamping untuk membantu memastikan kebutuhan energi harian terpenuhi.</li>
                        </ol>
                        <div class="text-end">
                            <a href="{{ route('home') }}" class="btn btn-outline-danger"><i class="ri-home-4-line me-1"></i>Tutup</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
