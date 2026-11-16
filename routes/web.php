<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\LaporanController;

// Halaman awal: arahkan sesuai status login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/angsuran', [AngsuranController::class, 'index'])
        ->name('angsuran.index');

    Route::get('/angsuran/{angsuran}', [AngsuranController::class, 'show'])
        ->name('angsuran.show');

    Route::post('/angsuran/{angsuran}/bayar', [AngsuranController::class, 'pay'])
        ->name('angsuran.pay');
});

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');

Route::get('/', function () {
 return redirect()->route('anggota.index');
});
Route::middleware('auth')->group(function () {
 Route::resource('anggota', AnggotaController::class);
});

Route::middleware(['auth'])->group(function () {

    Route::resource('pinjaman', PinjamanController::class);

    // Proses persetujuan
    Route::post(
        '/pinjaman/{pinjaman}/approve',
        [PinjamanController::class, 'approve']
    )->name('pinjaman.approve');

    // Proses penolakan
    Route::post(
        '/pinjaman/{pinjaman}/reject',
        [PinjamanController::class, 'reject']
    )->name('pinjaman.reject');

    // Proses pencairan
    Route::post(
        '/pinjaman/{pinjaman}/disburse',
        [PinjamanController::class, 'disburse']
    )->name('pinjaman.disburse');

    // Proses pelunasan
    Route::post(
        '/pinjaman/{pinjaman}/paid',
        [PinjamanController::class, 'markPaid']
    )->name('pinjaman.paid');

    // Pembatalan
    Route::post(
        '/pinjaman/{pinjaman}/cancel',
        [PinjamanController::class, 'cancel']
    )->name('pinjaman.cancel');
});


Route::middleware(['auth'])->group(function () {
    // Laporan pinjaman
    Route::get('/laporan/pinjaman', [LaporanController::class, 'index'])
        ->name('laporan.pinjaman');

    // Cetak laporan PDF
    Route::get('/laporan/pinjaman/pdf', [LaporanController::class, 'cetakLaporan'])
        ->name('laporan.pinjaman.pdf');

    // Cetak kartu angsuran
    Route::get('/laporan/kartu-angsuran/{pinjaman}', [LaporanController::class, 'kartuAngsuran'])
        ->name('laporan.kartu');

    // Cetak kwitansi
    Route::get('/laporan/kwitansi/{pembayaran}', [LaporanController::class, 'kwitansi'])
        ->name('laporan.kwitansi');
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