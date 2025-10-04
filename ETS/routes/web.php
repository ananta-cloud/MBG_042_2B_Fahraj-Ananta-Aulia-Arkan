<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Gudang
use App\Http\Controllers\Gudang\GudangDashboardController;
use App\Http\Controllers\Gudang\BahanBakuController;
use App\Http\Controllers\Gudang\ManageRequestController;

// Dapur
use App\Http\Controllers\Dapur\DapurDashboardController;
use App\Http\Controllers\Dapur\RequestController;


// Arahkan halaman utama ('/') ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// --- RUTE OTENTIKASI ---
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login')->middleware('guest');
    Route::post('login', 'loginUser')->middleware('guest');
    Route::post('logout', 'logout')->name('logout')->middleware('auth');
});

// --- RUTE UNTUK ADMIN (Gudang) ---
Route::middleware(['auth', 'role:gudang'])->prefix('gudang')->name('gudang.')->group(function () {
    Route::get('/dashboard', [GudangDashboardController::class, 'index'])->name('dashboard');

    Route::resource('bahan_baku', BahanBakuController::class);

    // Resource Controller untuk Kelola Request, dibatasi hanya untuk index dan show.
    // Parameter URL akan otomatis menjadi {kelola_request}
    Route::resource('kelola_request', ManageRequestController::class)->only(['index', 'show']);

    // Rute kustom untuk approve dan reject.
    // PERBAIKAN: Parameter {kelola_request} harus sama dengan nama resource.
    Route::post('kelola_request/{kelola_request}/approve', [ManageRequestController::class, 'approve'])->name('kelola_request.approve');
    Route::post('kelola_request/{kelola_request}/reject', [ManageRequestController::class, 'reject'])->name('kelola_request.reject');
});

// --- RUTE UNTUK Client (Dapur) ---
Route::middleware(['auth', 'role:dapur'])->prefix('dapur')->name('dapur.')->group(function () {
    Route::get('/dashboard', [DapurDashboardController::class, 'index'])->name('dashboard');

     Route::resource('request_bahan_baku', RequestController::class)->only(['index', 'create', 'store']);
});

