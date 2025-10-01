<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GudangDashboardController;
use App\Http\Controllers\DapurDashboardController;

// Arahkan halaman utama ('/') ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// --- RUTE OTENTIKASI ---
Route::controller(AuthController::class)->group(function () {
    // Terapkan middleware 'guest' untuk mencegah pengguna yang sudah login mengakses halaman ini lagi.
    Route::get('login', 'login')->name('login')->middleware('guest');
    Route::post('login', 'loginUser')->middleware('guest');

    // Logout hanya bisa diakses oleh pengguna yang sudah login ('auth')
    Route::post('logout', 'logout')->name('logout')->middleware('auth');
});

// --- RUTE UNTUK ADMIN (Gudang) ---
Route::middleware(['auth', 'role:gudang'])->prefix( 'gudang')->name('gudang.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [GudangDashboardController::class, 'index'])->name('dashboard');
});

// --- RUTE UNTUK Client (Dapur) ---
Route::middleware(['auth', 'role:dapur'])->prefix(prefix:'dapur')->name('dapur.')->group(function () {
    // Dashboard Client
    Route::get('/dashboard', [DapurDashboardController::class, 'index'])->name('dashboard');
});
