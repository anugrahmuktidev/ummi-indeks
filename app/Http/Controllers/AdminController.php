<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;



class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $user = Auth::user();

        // dd($user);
        return view('admin.dashboard',compact('user'));
        // Tampilkan halaman dashboard admin
    }

}
