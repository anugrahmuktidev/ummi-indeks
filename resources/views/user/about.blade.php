@extends('layouts.basic')

@section('content')
    <div class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 mb-4">
                    <div class="card-body p-4 p-md-5">
                        <span class="badge bg-warning text-dark px-3 py-2 mb-3">Tentang Aplikasi</span>
                        <h2 class="fw-bold-text text-dark mb-3">Prediksi Risiko Kekurangan Energi Kronis (KEK)</h2>
                        <p class="text-muted mb-4">
                            Aplikasi ini membantu tenaga kesehatan dan wanita usia subur menilai risiko Kekurangan Energi
                            Kronis menggunakan Indeks UMMI (Ukuran Menilai Malnutrisi Ibu). Seluruh fitur disusun agar proses
                            edukasi, perhitungan, serta tindak lanjut skrining berlangsung praktis dan terdokumentasi.
                        </p>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-4 bg-light rounded-4 h-100">
                                    <h5 class="fw-bold-text text-dark mb-3">Tujuan Pengembangan</h5>
                                    <ul class="list-unstyled mb-0 text-muted">
                                        <li class="mb-2">• Menyediakan materi edukasi risiko KEK yang mudah diakses.</li>
                                        <li class="mb-2">• Mempercepat perhitungan indikator gizi berbasis Indeks UMMI.</li>
                                        <li>• Mencatat riwayat skrining sehingga intervensi dapat dipantau.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 bg-light rounded-4 h-100">
                                    <h5 class="fw-bold-text text-dark mb-3">Teknologi Inti</h5>
                                    <ul class="list-unstyled mb-0 text-muted">
                                        <li class="mb-2">• Laravel + Livewire untuk logika aplikasi.</li>
                                        <li class="mb-2">• Tailwind & Bootstrap untuk antarmuka responsif.</li>
                                        <li>• Filament Admin untuk monitoring data skrining.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow rounded-4 mb-4">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold-text text-dark mb-4">Kredit & Kontributor</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="h-100">
                                    <h6 class="text-uppercase text-muted mb-3">Penanggung Jawab</h6>
                                    <ul class="list-group list-group-flush rounded-3 overflow-hidden">
                                        <li class="list-group-item">Dr. Ummi Kalsum, SKM., MKM</li>
                                        <li class="list-group-item">Tim Magister Kesehatan Masyarakat FKIK Universitas Jambi</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="h-100">
                                    <h6 class="text-uppercase text-muted mb-3">Peran Utama</h6>
                                    <ul class="list-group list-group-flush rounded-3 overflow-hidden">
                                        <li class="list-group-item">Riset & Validasi Indeks UMMI</li>
                                        <li class="list-group-item">Pengembangan Modul Edukasi & Video</li>
                                        <li class="list-group-item">Implementasi Sistem & Infrastruktur</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow rounded-4 mb-4">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold-text text-dark mb-3">Cara Menggunakan</h4>
                        <ol class="ps-3 text-muted">
                            <li class="mb-2">Lengkapi profil dan data antropometri pengguna.</li>
                            <li class="mb-2">Akses materi edukasi untuk memahami risiko KEK.</li>
                            <li class="mb-2">Gunakan kalkulator bantu hitung dan lakukan skrining.</li>
                            <li>Tinjau riwayat penilaian untuk tindak lanjut intervensi gizi.</li>
                        </ol>
                    </div>
                </div>

                <div class="card border-0 shadow rounded-4 mb-4">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold-text text-dark mb-3">Kontak & Dukungan</h4>
                        <p class="text-muted mb-4">Untuk kolaborasi, pengembangan lanjutan, atau pelaporan bug teknis
                            silakan menghubungi tim pengembang melalui email resmi Program Studi Magister Kesehatan Masyarakat
                            FKIK Universitas Jambi.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="mailto:info@fkik.unja.ac.id" class="btn btn-primary">
                                <i class="ri-mail-send-line me-2"></i>Email Pengembang
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="ri-arrow-go-back-line me-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
