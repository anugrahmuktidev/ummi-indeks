<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Menampilkan formulir login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        Log::info('Menampilkan formulir login.');

        // Generate captcha
        $captcha = $this->generateCaptcha();

        // Simpan hasil captcha ke sesi
        session(['captcha.result' => $captcha['result']]);

        // Kirim data captcha ke view
        return view('auth.login', compact('captcha'));
    }

    /**
     * Menghasilkan captcha.
     *
     * @return array
     */
    private function generateCaptcha()
    {
        Log::info('Menghasilkan captcha.');

        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $operation = rand(0, 1); // 0 untuk penjumlahan, 1 untuk pengurangan

        if ($operation === 0) {
            $result = $num1 + $num2;
            $expression = "$num1 + $num2";
        } else {
            $result = $num1 - $num2;
            $expression = "$num1 - $num2";
        }

        return [
            'num1' => $num1,
            'num2' => $num2,
            'operation' => $operation,
            'result' => $result,
            'expression' => $expression,
        ];
    }

    /**
     * Menangani proses login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
   public function login(Request $request)
    {
        $request->validate([
            'no_hp' => 'required|string',
            'captcha' => 'required|integer',
        ]);

        // Ambil captcha dari sesi
        $captcha = $request->session()->get('captcha.result');

        // Validasi captcha
        if ($request->captcha != $captcha) {
            return redirect()->back()->withErrors(['captcha' => 'Captcha tidak valid.'])->withInput();
        }

        // Autentikasi pengguna dengan nomor HP
        $user = User::authenticateByNoHp($request->no_hp);

        if ($user) {
            Auth::login($user);
            // dd($user);
            // dd($user->is_first_login);
            if ($user->is_first_login) {
                // dd('masuk sini');
                // Tindakan yang diambil untuk pengguna baru pertama kali
                // Misalnya, alihkan ke halaman onboarding
                return redirect()->route('pretest.disclaimer');
            }

        }
        return redirect()->intended('home'); // Arahkan ke halaman setelah login

        return redirect()->back()->withErrors(['no_hp' => 'Nomor HP tidak ditemukan.'])->withInput();
    }
}
