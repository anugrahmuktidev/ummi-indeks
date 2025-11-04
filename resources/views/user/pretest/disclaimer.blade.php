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
                <p class="text-center">Bagian ini merupakan Pre-Test untuk memetakan pengetahuan dasar Anda mengenai
                    Kurang Energi Kronis (KEK), faktor penyebabnya, dan pencegahannya.</p>
                @if (!Auth::user()->has_completed_pretest)
                    <div class="text-center mt-4">
                        <a href="{{ route('pretest.test') }}" class="btn btn-primary">
                            <i class="ri-flight-takeoff-line me-1"></i>Mulai Pretest
                        </a>
                    </div>
                @else
                    <div class="alert alert-success mt-4 text-center">
                        <i class="ri-checkbox-circle-line me-1"></i>Anda sudah menyelesaikan pretest.
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="ri-home-4-line me-1"></i>Kembali ke Beranda
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
