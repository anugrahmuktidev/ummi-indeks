@extends('layouts.basic')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body bg-warning">
                <div class="text-center fw-bold-text">
                    <h3 class="text-center fw-bold-text"> Halo, {{ Auth::user()->name }} !</h3>
                </div>
            </div>
            <div class="card-body p-4">
                <p class="text-center">Bagian ini merupakan <span class="fst-italic">Post-Test</span> untuk menilai kembali
                    pemahaman Anda mengenai pencegahan Kurang Energi Kronis (KEK) setelah mempelajari materi edukasi.</p>
                <p class="text-center">Sebelum memulai, Anda akan diminta memilih berapa kali sudah membaca/menyimak materi
                    edukasi.</p>
                <div class="text-center mt-4">
                    <a href="{{ route('posttest.test') }}" class="btn btn-primary">
                        <i class="ri-flight-takeoff-line me-1"></i>Mulai Post-Test
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
