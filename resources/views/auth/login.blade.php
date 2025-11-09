@extends('layouts.basic')

@section('content')
    <style>
        .login-card {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);
            backdrop-filter: blur(8px);
        }

        @media (max-width: 576px) {
            .login-card {
                background: rgba(255, 255, 255, 0.6);
                border-radius: 20px;
            }

            .login-card .card-body {
                padding: 1.75rem;
            }
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4 card-bg-fill login-card">
                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Selamat Datang Kembali !</h5>
                        <p class="text-muted">Masuk ke Sistem.</p>
                    </div>
                    <div class="p-2 mt-3">
                        <form method="POST" action="{{ route('post.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor Hp</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp"
                                    placeholder="Masukan No HP">
                                @error('no_hp')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="captcha" class="form-label">Apa hasil dari
                                    {{ $captcha['expression'] }}?</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="number" class="form-control pe-5" id="captcha" name="captcha"
                                        placeholder="Masukkan hasil" required>
                                    @error('captcha')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit"><i class="ri-login-box-line me-1"></i>Masuk</button>
                            </div>
                        </form>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Belum Punya Akun ? <a href="{{ route('register') }}"
                                    class="fw-semibold text-primary text-decoration-underline"> Daftar </a> </p>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

        </div>
    </div>
@endsection
