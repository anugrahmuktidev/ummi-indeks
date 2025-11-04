@extends('layouts.basic')

@section('content')
    @php($user = Auth::user())

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="bg-gradient position-relative" style="background: linear-gradient(120deg, #3b82f6 0%, #22d3ee 100%); height: 160px;">
                </div>
                <div class="card-body pt-0">
                    <div class="row align-items-end g-4">
                        <div class="col-md-4 text-center text-md-start">
                            <div class="avatar-xl position-relative" style="margin-top: -70px;">
                                <div class="rounded-circle bg-white shadow d-inline-flex align-items-center justify-content-center" style="width: 130px; height: 130px;">
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
                                    <div class="p-3 rounded border border-primary-subtle bg-primary-subtle h-100">
                                        <p class="text-uppercase text-primary small mb-1">Tanggal Lahir</p>
                                        <h5 class="mb-0">{{ optional($user->tanggal_lahir)->format('d M Y') ?? '-' }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="p-3 rounded border border-warning-subtle bg-warning-subtle h-100">
                                        <p class="text-uppercase text-warning small mb-1">Berat / Tinggi</p>
                                        <h5 class="mb-0">{{ $user->berat_badan ?? '-' }} kg • {{ $user->tinggi_badan ?? '-' }} cm</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="p-3 rounded border border-success-subtle bg-success-subtle h-100">
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
                            <h5 class="fw-bold-text text-primary mb-3"><i class="ri-user-3-line me-2"></i>Data Diri</h5>
                            <ul class="list-group list-group-flush">
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
                            <h5 class="fw-bold-text text-primary mb-3"><i class="ri-community-line me-2"></i>Domisili</h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">RT / No Rumah</p>
                                        <h6 class="mb-0">{{ $user->rt ?? '-' }} / {{ $user->no_rumah ?? '-' }}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Kelurahan</p>
                                        <h6 class="mb-0">{{ \Illuminate\Support\Str::title($user->kelurahan ?? '-') }}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Kecamatan</p>
                                        <h6 class="mb-0">{{ \Illuminate\Support\Str::title($user->kecamatan ?? '-') }}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Kabupaten</p>
                                        <h6 class="mb-0">{{ \Illuminate\Support\Str::title($user->kabupaten ?? '-') }}</h6>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Provinsi</p>
                                        <h6 class="mb-0">{{ \Illuminate\Support\Str::title($user->provinsi ?? '-') }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-end mt-4">
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
