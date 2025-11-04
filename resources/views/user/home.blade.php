@extends('layouts.basic')
@section('content')
    <style>
        .dashboard-card {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.15);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            color: #0f172a;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.2);
        }

        .dashboard-card .stretched-link {
            color: inherit;
            text-decoration: none;
        }

        .dashboard-card .stretched-link:hover {
            color: #2563eb;
        }

        .dashboard-card-title {
            color: #0f172a;
        }

        .dashboard-card-step {
            color: #1f2937;
            opacity: 0.7;
        }
    </style>
    <div class="container-fluid">
        <div class="row row-cols-2 row-cols-md-2 g-4">
            <div class="col">
                <div class="card dashboard-card">
                    <div class="card-body text-center py-4">
                        <lord-icon src="https://cdn.lordicon.com/fmasbomy.json" trigger="hover" colors="primary:#405189"
                            target="div" style="width:80px;height:80px"></lord-icon>
                        <a href="{{ route('user.profil') }}" class="stretched-link">
                            <h5 class="mt-4 fw-bold-text dashboard-card-title">Profil <span
                                    class="fw-bold-text">{{ Auth::user()->name }}</span>
                            </h5>
                        </a>
                        <h5 class="mt-4 fw-bold-text dashboard-card-step">( 1 )</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card dashboard-card">
                    <div class="card-body text-center py-4">
                        <lord-icon src="https://cdn.lordicon.com/svsiboke.json" trigger="hover"
                            colors="primary:#121331,secondary:#ebe6ef,tertiary:#f24c00,quaternary:#a866ee,quinary:#f9c9c0,senary:#3a3347"
                            target="div" style="width:80px;height:80px"></lord-icon>
                        <a href="{{ route('show.video', ['kembali' => true]) }}" class="stretched-link">
                            <h5 class="mt-4 fw-bold-text dashboard-card-title">Edukasi Risiko KEK</h5>
                        </a>
                        <h5 class="mt-4 fw-bold-text dashboard-card-step">( 2 )</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-md-2 g-4 mt-4"> <!-- Baris baru untuk card ketiga dan keempat -->
            <div class="col">
                <div class="card dashboard-card">
                    <div class="card-body text-center py-4">
                        <lord-icon src="https://cdn.lordicon.com/fbbaczvt.json" trigger="hover" colors="primary:#405189"
                            target="div" style="width:80px;height:80px"></lord-icon>
                        <a href="{{ route('measurement.form') }}" class="stretched-link">
                            <h5 class="mt-4 fw-bold-text dashboard-card-title">Kalkulator Bantu Hitung KEK</h5>
                        </a>
                        <h5 class="mt-4 fw-bold-text dashboard-card-step">( 3 )</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card dashboard-card">
                    <div class="card-body text-center py-4">
                        <lord-icon src="https://cdn.lordicon.com/ujxzdfjx.json" trigger="hover" colors="primary:#405189"
                            target="div" style="width:80px;height:80px"></lord-icon>
                        <a href="{{ route('skrining.history') }}" class="stretched-link">
                            <h5 class="mt-4 fw-bold-text dashboard-card-title">Riwayat Penilaian Risiko KEK</h5>
                        </a>
                        <h5 class="mt-4 fw-bold-text dashboard-card-step">( 4 )</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
@endsection
