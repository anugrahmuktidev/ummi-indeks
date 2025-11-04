<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Buat instance controller.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // Middleware ini memastikan pengguna terautentikasi
    }

    /**
     * Tampilkan halaman beranda aplikasi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user(); // Ambil data pengguna yang terautentikasi

        // Dapatkan data atau lakukan logika tambahan sesuai kebutuhan

        return view('user.home', ['user' => $user]); // Tampilkan view 'home' dengan data pengguna
    }
}
