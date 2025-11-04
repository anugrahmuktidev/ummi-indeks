@extends('layouts.basic')

@section('content')
    <div class="alert alert-secondary text-center mb-4" role="alert">
        <strong> Gulir/Scroll</strong> ke bawah untuk membaca dan melanjutkan ke tahap selanjutnya!
    </div>
    @php
        $leaflets = $leaflets ?? [];
        $activeLeaflet ??= array_key_first($leaflets);
        $currentLeaflet = $leaflets[$activeLeaflet] ?? null;
        $kembaliParam = $kembali ? 1 : null;
        $currentFileUrl = $currentLeaflet
            ? asset(str_replace(' ', '%20', $currentLeaflet['file']))
            : null;
        $downloadedLeaflets = collect($downloadedLeaflets ?? [])->unique()->values()->all();
        $totalLeaflets ??= count($leaflets);
        $allLeafletsDownloaded ??= ($hasDownloaded ?? false);
        $nextClass = $allLeafletsDownloaded ? '' : 'd-none';
    @endphp
    <style>
        .leaflet-tabs .nav-link {
            border-radius: 999px;
            font-weight: 600;
        }

        .leaflet-tabs .nav-link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.9), rgba(14, 116, 144, 0.9));
            color: #fff;
        }

        .leaflet-viewer {
            height: clamp(560px, 90vh, 1000px);
            background-color: rgba(15, 23, 42, 0.25);
            border-radius: 24px;
            overflow: auto;
        }

        .leaflet-frame {
            width: 100%;
            height: 100%;
            border: none;
        }

        .leaflet-info-card {
            background: rgba(15, 23, 42, 0.45);
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 18px;
            padding: 1.25rem;
            transition: border-color 0.2s ease, transform 0.2s ease, background 0.2s ease,
                box-shadow 0.2s ease;
            min-height: 100%;
        }

        .leaflet-info-card:hover {
            border-color: rgba(96, 165, 250, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.35);
        }

        .leaflet-info-card.active {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.32), rgba(8, 47, 73, 0.65));
            border-color: rgba(96, 165, 250, 0.9);
            box-shadow: 0 14px 30px rgba(30, 64, 175, 0.35);
        }

        .leaflet-info-card h5 {
            color: #f8fafc;
        }

        .leaflet-info-card p {
            color: rgba(226, 232, 240, 0.85);
        }

        @media (max-width: 768px) {
            .leaflet-viewer {
                height: 75vh;
            }
        }

    </style>

    <div class="row g-4 justify-content-center">
        <div class="col-12 col-lg-12 d-flex align-items-start">
            <div class="ribbon-box shadow-none mb-lg-0 w-100">
                <div class="card justify-content-center p-3">

                    <div class="row row-cols-1 row-cols-lg-2 g-3 mt-4">
                        @foreach ($leaflets as $slug => $leafletOption)
                            @php
                                $params = ['leaflet' => $slug];
                                if ($kembaliParam !== null) {
                                    $params['kembali'] = $kembaliParam;
                                }
                                $link = route('leaflet.view', $params);
                            @endphp
                            <div class="col">
                                <div class="leaflet-info-card d-flex flex-column gap-3 {{ $slug === $activeLeaflet ? 'active' : '' }}">
                                    <div>
                                        <h5 class="mb-2">{{ $leafletOption['title'] }}</h5>
                                        <p class="mb-0 small">{{ $leafletOption['description'] }}</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <span class="badge rounded-pill {{ $slug === $activeLeaflet ? 'bg-info text-dark' : 'bg-secondary text-white' }}">
                                            {{ $slug === $activeLeaflet ? 'Sedang dibaca' : 'Siap dibuka' }}
                                        </span>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a class="btn btn-warning btn-sm material-shadow-none download-leaflet-button"
                                                data-leaflet="{{ $slug }}"
                                                href="{{ route('leaflet.download', ['leaflet' => $slug]) }}" target="_blank">
                                                <i class="ri-book-read-line align-middle me-1"></i> Unduh Leaflet
                                            </a>
                                            <a class="btn btn-info btn-sm material-shadow-none" href="{{ $link }}">
                                                <i class="ri-eye-line align-middle me-1"></i> Lihat Leaflet
                                            </a>
                                        </div>
                                    </div>
                                    @if ($slug === $activeLeaflet)
                                        @unless($kembali)
                                            <p id="leafInfo"
                                                class="mb-0 small text-warning fw-semibold {{ $allLeafletsDownloaded ? 'd-none' : '' }}">
                                                Selesaikan unduhan kedua leaflet sebelum melanjutkan ke tahap berikutnya.
                                            </p>
                                        @endunless
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($kembali)
                        <div class="d-flex justify-content-start mt-3">
                            <a href="{{ route('home') }}" class="btn btn-outline-success material-shadow-none">
                                <i class="ri-close-circle-line align-middle"></i> Tutup
                            </a>
                        </div>
                    @endif
                    <div class="mt-4">
                        @if ($currentLeaflet && $currentFileUrl)
                            <div class="leaflet-viewer shadow-sm border border-light-subtle">
                                <iframe class="leaflet-frame" src="{{ $currentFileUrl }}#zoom=page-actual"
                                    title="{{ $currentLeaflet['title'] }}" loading="lazy"></iframe>
                            </div>
                            <p class="text-center text-white-50 fw-medium mt-3">{{ $currentLeaflet['description'] }}</p>
                            @unless($kembali)
                                <a href="{{ route('measurement.form') }}" id="nextButton"
                                    class="btn btn-success material-shadow-none w-100 mt-4 {{ $nextClass }}"
                                    aria-hidden="{{ $allLeafletsDownloaded ? 'false' : 'true' }}">
                                    <i class="ri-arrow-right-line align-middle me-1"></i> Selanjutnya
                                </a>
                            @endunless
                        @else
                            <div class="alert alert-warning mt-3" role="alert">
                                Leaflet tidak tersedia saat ini.
                            </div>
                        @endif
                    </div>
                    <h3 class="text-center my-2 text-white">Leaflet Edukasi Kurang Energi Kronis (KEK)</h3>

            </div>
        </div>

    </div>

    <script>
        const totalLeaflets = {{ $totalLeaflets }};
        const downloadedLeaflets = new Set(@json($downloadedLeaflets));
        const nextButton = document.getElementById('nextButton');
        const info = document.getElementById('leafInfo');

        const updateNextButtonState = () => {
            if (!nextButton) {
                return;
            }

            const hasAll = downloadedLeaflets.size >= totalLeaflets;

            nextButton.classList.toggle('d-none', !hasAll);
            nextButton.setAttribute('aria-hidden', hasAll ? 'false' : 'true');

            if (info) {
                info.classList.toggle('d-none', hasAll);
            }
        };

        updateNextButtonState();

        document.querySelectorAll('.download-leaflet-button').forEach((button) => {
            button.addEventListener('click', () => {
                const leaflet = button.dataset.leaflet;
                if (leaflet) {
                    downloadedLeaflets.add(leaflet);
                }
                updateNextButtonState();
            });
        });
    </script>
@endsection
