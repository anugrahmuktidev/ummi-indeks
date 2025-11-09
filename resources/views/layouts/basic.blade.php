<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Prediksi KEK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/img/logo-unja.png') }}">
    <script src="{{ asset('assets/js/layout.js') }}"></script>

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    @livewireStyles

    <style>
        body {
            margin: 0;
            padding: 0;
            --vz-body-bg-image: url("{{ asset('assets/img/bgmain-desktop.png') }}");
            background: url("{{ asset('assets/img/bgmain-desktop.png') }}") center / cover no-repeat fixed !important;
            min-height: 100vh;
            font-family: 'Arial Nero', sans-serif;
        }

        .fw-bold-text {
            font-weight: bold;
        }

        .auth-page-wrapper {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: url("{{ asset('assets/img/bgmain-desktop.png') }}") center / cover no-repeat fixed;
        }

        .auth-page-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.2);
            z-index: 0;
        }

        .auth-page-content {
            position: relative;
            width: 100%;
            z-index: 1;
        }

        h1 {
            font-size: 1.4rem;
            /* Memperbesar ukuran font h1 */
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            body {
                --vz-body-bg-image: url("{{ asset('assets/img/bgmain-mobile.png') }}");
                background: url("{{ asset('assets/img/bgmain-mobile.png') }}") center / cover no-repeat fixed !important;
            }

            .auth-page-wrapper {
                background: url("{{ asset('assets/img/bgmain-mobile.png') }}") center / cover no-repeat fixed;
            }

            h1 {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 1.4rem;
            }

            .fs-15 {
                font-size: 0.9rem;
            }

            .row img {
                height: 30px;
            }

            .col-md-1 {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        .logo-size {
            max-height: 80px;
            /* Atur tinggi maksimum logo */
            width: auto;
            /* Memastikan lebar otomatis sesuai rasio */
        }

        .logo-size-large {
            height: 110px;
            /* Paksa tinggi lebih besar untuk logo yang lebar */
            width: auto;
        }

        .card-logo {
            background-color: white;
            border-radius: 40px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 820px;
            margin: 0 auto;
            text-align: center;
        }

        .row-logo {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .logo-col {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1 1 150px;
            max-width: 170px;
        }

        @media (max-width: 768px) {
            .row-logo {
                gap: 0;
            }

            .row-logo .row {
                --bs-gutter-x: 0;
                --bs-gutter-y: 0;
            }

            .row-logo .logo-col {
                flex: 0 0 32%;
                max-width: 32%;
                padding-left: 2px !important;
                padding-right: 2px !important;
            }

            .card-logo {
                padding: 6px 4px;
            }

            .logo-size {
                max-height: 48px;
            }
        }

        @media (max-width: 576px) {
            .row-logo .logo-col {
                flex: 0 0 33.33%;
                max-width: 33.33%;
            }

            .card-logo {
                border-radius: 24px;
                padding: 6px 4px;
            }

            .logo-size {
                max-height: 44px;
            }
        }
    </style>

</head>

<body>
    <div class="auth-page-wrapper">
        <div class="auth-page-content">
            <div class="container">
                <div class="row-logo">
                    <div class="col-lg-8">
                        <div class="text-center text-white-50">
                            <div class="card-logo">
                                <div class="row g-2 justify-content-center align-items-center">
                                    <div class="col-4 col-sm-3 col-md-2 col-xl-2 logo-col">
                                        <img src="{{ asset('assets/img/kemendikbud.png') }}" alt=""
                                            class="img-fluid logo-size">
                                    </div>
                                    <div class="col-4 col-sm-3 col-md-2 col-xl-2 logo-col">
                                        <img src="{{ asset('assets/img/logo-unja.png') }}" alt=""
                                            class="img-fluid logo-size">
                                    </div>
                                    <div class="col-8 col-sm-4 col-md-3 col-xl-3 logo-col">
                                        <img src="{{ asset('assets/img/dikti-saintek2.png') }}" alt=""
                                            class="img-fluid logo-size">
                                    </div>
                                </div>
                            </div>




                            <div class="my-3">
                                <h3 class="fw-bold-text text-white mt-4">Prediksi Risiko Kekurangan Energi
                                    Kronis (KEK) <br>pada Wanita Usia Subur (WUS)</h3>
                            <p class="fs-15 fw-medium text-white">Menggunakan Indeks UMMI (Ukuran Menilai
                                    Malnutrisi Ibu)</p>
                            </div>
                        </div>
                    </div>
                </div>

                @yield('content')
                @isset($slot)
                    {{ $slot }}
                @endisset

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            {{-- <p class="mt-3 fs-15 fw-medium text-white"> Prodi S3 Pendidikan MIPA Program
                                Pascasarjana Universitas Jambi </p> --}}
                            <p class="mt-3 fs-15 fw-medium text-white"> Prodi Magister Kesehatan Masyarakat FKIK
                                Universitas Jambi </p>
                            {{-- <p> Bekerjasama dengan : </p>
                            <p class="mt-3 fs-15 fw-medium text-white"> Poltekkes Kemenkes RI Jambi </p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
