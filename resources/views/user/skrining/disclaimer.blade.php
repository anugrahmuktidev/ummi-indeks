@extends('layouts.basic')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body bg-warning">
                <h3 class="text-center fw-bold-text"> Selamat Datang, {{ Auth::user()->name }} !</h3>
            </div>
            <div class="card-body p-4">
                <h3 class="text-center fw-bold-text">Disclaimer</h3>
                {{-- <p class="text-center">Harap baca informasi berikut dengan seksama sebelum memulai pretest.</p> --}}
                <p class="text-center">Skrining ini membantu memprediksi risiko Kurang Energi Kronis (KEK) berdasarkan
                    jawaban Anda. Mohon isi setiap pertanyaan sesuai kondisi sebenarnya agar rekomendasi yang diberikan
                    akurat dan bermanfaat.</p>
                <div class="text-center mt-4">
                    <a href="{{ route('skrining.test') }}" class="btn btn-primary">
                        <i class="ri-flight-takeoff-line me-1"></i>Mulai Skrining
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
