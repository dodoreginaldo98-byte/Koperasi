<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;

// Halaman awal: arahkan sesuai status login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');

Route::get('/', function () {
 return redirect()->route('anggota.index');
});
Route::middleware('auth')->group(function () {
 Route::resource('anggota', AnggotaController::class);
});

Route::middleware('role:admin')->group(function () {
    Route::resource('users', UserController::class);

    Route::post('simpanan/{simpanan}/verifikasi', [SimpananController::class, 'verifikasi'])
        ->name('simpanan.verifikasi');
    Route::post('simpanan/{simpanan}/tolak', [SimpananController::class, 'tolak'])
        ->name('simpanan.tolak');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('anggotas', AnggotaController::class);
    Route::resource('simpanans', SimpananController::class);

    // Khusus admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__ . '/auth.php';