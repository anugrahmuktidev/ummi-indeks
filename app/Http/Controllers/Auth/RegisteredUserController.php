<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15|unique:users',
            'tanggal_lahir' => 'required|date', // Mengganti 'usia' dengan 'tanggal_lahir'
            'jenis_kelamin' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'pekerjaan_lain' => 'nullable|string|max:255', // Menambahkan validasi untuk pekerjaan lain
            'alamat' => 'required|string',
            'norumah' => 'required|string|max:10',
            'rt' => 'required|string|max:10',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'berat_badan' => 'nullable|numeric|min:0', // Validasi berat badan
            'tinggi_badan' => 'nullable|numeric|min:0', // Validasi tinggi badan
        ]);
        // dd($validatedData);
        // Tambahkan logika untuk memastikan 'pekerjaan_lain' diisi jika 'pekerjaan' adalah 'Lainnya'
        if ($validatedData['pekerjaan'] === 'Lainnya' && empty($validatedData['pekerjaan_lain'])) {
            throw ValidationException::withMessages([
                'pekerjaan_lain' => 'Sebutkan pekerjaan lainnya jika memilih "Lainnya".'
            ]);
        }
        // dd($validatedData);

        try {
            // Store user without email and password
            $user = User::create([
                'name' => $validatedData['name'],
                'no_hp' => $validatedData['no_hp'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'], // Menyimpan tanggal lahir
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'pendidikan' => $validatedData['pendidikan'],
                'pekerjaan' => $validatedData['pekerjaan'],
                'pekerjaan_lain' => $validatedData['pekerjaan'] === 'Lainnya' ? $validatedData['pekerjaan_lain'] : null, // Menyimpan pekerjaan lainnya jika dipilih
                'alamat' => $validatedData['alamat'],
                'no_rumah' => $validatedData['norumah'],
                'rt' => $validatedData['rt'],
                'kelurahan' => $validatedData['kelurahan'],
                'kecamatan' => $validatedData['kecamatan'],
                'kabupaten' => $validatedData['kabupaten'],
                'provinsi' => $validatedData['provinsi'],
                'berat_badan' => $validatedData['berat_badan'], // Menyimpan berat badan
                'tinggi_badan' => $validatedData['tinggi_badan'], // Menyimpan tinggi badan
                'role' => 'user', // default value
                'profile_completed' => true,
            ]);

            // dd($user);

            // Set success message
            session()->forget('error'); // Pastikan pesan error tidak ada
            Session::flash('success', 'Akun berhasil dibuat, Silahkan Login.');
            return redirect()->back();

        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi kesalahan pada database
            session()->forget('success');
            Session::flash('error', 'Terjadi kesalahan database: ' . $e->getMessage());
            return redirect()->back()->withInput();

        } catch (\Exception $e) {
            // Jika terjadi kesalahan umum lainnya
            session()->forget('success');
            Session::flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

    }
}
