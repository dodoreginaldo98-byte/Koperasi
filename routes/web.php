<?php

use App\Http\Controllers\UserController;
//use App\Http\Controllers\SimpananController;
use App\Http\Controllers\AuthController;
//use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
use App\Http\Controllers\Auth\AuthenticatedSessionController; //


Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
});
//Sesuaikan dengan controller login Anda

// Untuk menampilkan form login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

// Untuk memproses data saat tombol login ditekan (POST)
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard'); // Pastikan file resources/views/dashboard.blade.php ada
})->name('dashboard');

// Atau jika langsung mengarah ke view blade
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('dashboard', fn () => view('dashboard'))->name('dashboard');
});


Route::get('/', function () {
 return redirect()->route('users.index');
})->middleware('auth');
Route::middleware('auth')->group(function () {
 //Route::resource('anggota', AnggotaController::class);
 //Route::resource('simpanan', SimpananController::class);
});
//Route::middleware(['auth', 'role:admin'])->group(function () {
 Route::resource('users', UserController::class);
//});
