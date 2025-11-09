@extends('layouts.basic')

@section('content')
    @php($user = Auth::user())

    <style>
        .profile-wrapper .profile-card {
            border: none;
            border-radius: 32px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);
            backdrop-filter: blur(12px);
        }

        .profile-hero {
            background: linear-gradient(120deg, #4338ca 0%, #2563eb 45%, #14b8a6 100%);
            height: 190px;
        }

        .profile-avatar {
            margin-top: -80px;
        }

        .profile-avatar .avatar-ring {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, 0.4);
            background: linear-gradient(135deg, #ffffff, #e2e8f0);
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.2);
        }

        .profile-stat-card {
            border: none;
            border-radius: 22px;
            color: #0f172a;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }

        .profile-stat-card--date {
            background-image: linear-gradient(135deg, #dbeafe, #a5b4fc);
        }

        .profile-stat-card--bt {
            background-image: linear-gradient(135deg, #fef9c3, #fcd34d);
        }

        .profile-stat-card--education {
            background-image: linear-gradient(135deg, #bbf7d0, #6ee7b7);
        }

        .profile-stat-card p {
            letter-spacing: 0.08em;
        }

        .profile-details .list-group-item {
            border: 0;
            border-radius: 18px;
            background: rgba(148, 163, 184, 0.12);
            margin-bottom: 12px;
            padding: 16px 20px;
        }

        .profile-details .list-group-item:last-child {
            margin-bottom: 0;
        }

        .profile-info-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 20px;
            padding: 18px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.85), rgba(241, 245, 249, 0.95));
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.1);
            height: 100%;
        }

        .profile-section-title {
            font-size: 1.05rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .profile-cta .btn {
            border-radius: 999px;
            font-weight: 600;
            padding: 12px 24px;
        }

        @media (max-width: 767px) {
            .profile-stat-card {
                text-align: center;
            }

            .profile-details .list-group-item {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 6px;
            }
        }

        @media (max-width: 576px) {
            .profile-avatar .avatar-ring {
                width: 110px;
                height: 110px;
            }

            .profile-cta {
                flex-direction: column;
            }
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10 profile-wrapper">
            <div class="card profile-card overflow-hidden">
                <div class="profile-hero position-relative">
                </div>
                <div class="card-body pt-0">
                    <div class="row align-items-end g-4">
                        <div class="col-md-4 text-center text-md-start">
                            <div class="avatar-xl position-relative profile-avatar">
                                <div class="avatar-ring d-inline-flex align-items-center justify-content-center">
                                    <span class="display-5 fw-bold-text text-primary">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 1)) }}</span>
                                </div>
                            </div>
                            <h3 class="fw-bold-text mt-3 mb-1">{{ \Illuminate\Support\Str::title($user->name) }}</h3>
                            <div class="text-muted">
                                <i class="ri-cellphone-line me-1 text-primary"></i>{{ $user->no_hp ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <div class="p-3 profile-stat-card profile-stat-card--date h-100">
                                        <p class="text-uppercase text-primary small mb-1">Tanggal Lahir</p>
                                        <h5 class="mb-0">{{ optional($user->tanggal_lahir)->format('d M Y') ?? '-' }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="p-3 profile-stat-card profile-stat-card--bt h-100">
                                        <p class="text-uppercase text-warning small mb-1">Berat / Tinggi</p>
                                        <h5 class="mb-0">{{ $user->berat_badan ?? '-' }} kg • {{ $user->tinggi_badan ?? '-' }} cm</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="p-3 profile-stat-card profile-stat-card--education h-100">
                                        <p class="text-uppercase text-success small mb-1">Status Pendidikan</p>
                                        <h5 class="mb-0">{{ \Illuminate\Support\Str::title($user->pendidikan ?? '-') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold-text text-primary mb-3 profile-section-title"><i class="ri-user-3-line me-2"></i>Data Diri</h5>
                            <ul class="list-group list-group-flush profile-details">
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <div><i class="ri-venus-mars-line text-primary me-2"></i>Jenis Kelamin</div>
                                    <span class="fw-medium">{{ \Illuminate\Support\Str::title($user->jenis_kelamin ?? '-') }}</span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <div><i class="ri-briefcase-4-line text-primary me-2"></i>Pekerjaan</div>
                                    <span class="fw-medium">
                                        {{ \Illuminate\Support\Str::title($user->pekerjaan === 'Lainnya' ? $user->pekerjaan_lain : ($user->pekerjaan ?? '-')) }}
                                    </span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <div><i class="ri-map-pin-2-line text-primary me-2"></i>Alamat</div>
                                    <span class="fw-medium text-end" style="max-width: 260px;">{{ \Illuminate\Support\Str::title($user->alamat ?? '-') }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold-text text-primary mb-3 profile-section-title"><i class="ri-community-line me-2"></i>Domisili</h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="profile-info-card">
                                        <p class="text-muted mb-1">RT / No Rumah</p>
                                        <h6 class="mb-0">{{ $user->rt ?? '-' }} / {{ $user->no_rumah ?? '-' }}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="profile-info-card">
                                        <p class="text-muted mb-1">Kelurahan</p>
                                        <h6 class="mb-0">{{ \Illuminate\Support\Str::title($user->kelurahan ?? '-') }}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="profile-info-card">
                                        <p class="text-muted mb-1">Kecamatan</p>
                                        <h6 class="mb-0">{{ \Illuminate\Support\Str::title($user->kecamatan ?? '-') }}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="profile-info-card">
                                        <p class="text-muted mb-1">Kabupaten</p>
                                        <h6 class="mb-0">{{ \Illuminate\Support\Str::title($user->kabupaten ?? '-') }}</h6>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="profile-info-card">
                                        <p class="text-muted mb-1">Provinsi</p>
                                        <h6 class="mb-0">{{ \Illuminate\Support\Str::title($user->provinsi ?? '-') }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-end mt-4 profile-cta">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary w-100 w-md-auto">
                            <i class="ri-home-4-line me-1"></i>Tutup
                        </a>
        
                        <form method="POST" action="{{ route('logout') }}" class="mb-0 w-100 w-md-auto">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100 w-md-auto">
                                <i class="ri-logout-circle-line me-1"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
