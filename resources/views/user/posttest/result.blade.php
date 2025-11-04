{{-- resources/views/user/pretest/result.blade.php --}}
@extends('layouts.basic')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="bg-warning">
                <div class="card-body p-3">
                    <div class="text-center fw-bold-text">
                        <h3>Hasil Post Test</h3>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">

                <div class="text-center mt-3 fs-4">
                    <p>Skor Anda : </p>
                    <h1 class="display-2">{{ $totalBenar }}</h1>
                </div>


                <div class="text-center mt-4">
                    <a href="{{ route('skrining.disclaimer') }}" class="btn btn-primary"><i class="ri-user-heart-line me-1"></i>Tutup</a>
                </div>
            </div>
        </div>
    </div>
@endsection
