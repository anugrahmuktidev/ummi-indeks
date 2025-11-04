@extends('layouts.app')
@section('content')
    <div>
        <h4>Selamat datang, {{ $user->name }} !</h4>

        @if ($errors->any())
            <div class="alert alert-danger">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


    </div>
@endsection
