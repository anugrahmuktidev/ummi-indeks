<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/dashboard');
            } else {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Anda tidak memiliki akses admin.']);
            }
        }

        return redirect()->back()->withErrors(['email' => 'Kredensial tidak valid.']);
    }
}
