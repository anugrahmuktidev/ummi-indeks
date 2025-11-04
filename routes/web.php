<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PretestController;
use App\Http\Controllers\SkriningController;
use App\Livewire\MeasurementForm;
use App\Livewire\RiskAssessmentForm;
use App\Http\Controllers\Auth\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/admin-login-unique', fn () => redirect()->to('/admin/login'))->name('admin.login');
Route::post('/admin-login-unique', fn () => redirect()->to('/admin/login'));

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('filament.admin.pages.dashboard'))->name('admin.dashboard');
});

Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('post.login')->middleware('guest');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/soal', fn () => redirect('/admin/soals'))->name('admin.soal.index');
    Route::get('/users', fn () => redirect('/admin/users'))->name('admin.users.index');
    Route::get('/jawaban', fn () => redirect('/admin/jawabans'))->name('admin.jawaban.index');
    Route::get('/skrining', fn () => redirect('/admin/riwayat-skrinings'))->name('admin.data.skrining');
    Route::get('/pretest', fn () => redirect()->route('filament.admin.pages.pretest-results'))->name('admin.data.pretest');
    Route::get('/posttest', fn () => redirect()->route('filament.admin.pages.posttest-results'))->name('admin.data.posttest');
});

Route::post('/password/update', [PasswordController::class, 'update'])->name('password.update');

Route::get('/home', function () {
    return view('user.home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware(['auth', 'checkfirstlogin'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/profil', function () {
        return view('user.profil');
    })->name('user.profil');
    Route::get('/home/riwayat', [SkriningController::class, 'viewSkriningHistory'])->name('skrining.history');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pretest/disclaimer', function () {
        return view('user.pretest.disclaimer');
    })->name('pretest.disclaimer');
    Route::get('/pretest/test', \App\Livewire\PretestSession::class)->name('pretest.test');

    Route::get('/posttest/disclaimer', function () {
        return view('user.posttest.disclaimer');
    })->name('posttest.disclaimer');
    Route::get('/posttest/test', \App\Livewire\PosttestSession::class)->name('posttest.test');

    Route::get('/skrining/disclaimer', function () {
        return view('user.skrining.disclaimer');
    })->name('skrining.disclaimer');
    Route::get('/skrining/test', \App\Livewire\SkriningSession::class)->name('skrining.test');
    Route::get('/measurement', MeasurementForm::class)->name('measurement.form');
    Route::get('/risk-assessment', RiskAssessmentForm::class)->name('risk.form');
    Route::get('/risk-assessment/result', \App\Livewire\RiskAssessmentResult::class)->name('risk.result');

    Route::get('/video/{kembali?}', [PretestController::class, 'showVideo'])->name('show.video');
    Route::get('/leaflet/download/{leaflet}', [PretestController::class, 'downloadLeaflet'])->name('leaflet.download');
    Route::get('/leaflet/view/{leaflet}/{kembali?}', [PretestController::class, 'showLeaflet'])->name('leaflet.view');
});

require __DIR__ . '/auth.php';
