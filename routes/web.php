<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanPdfController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\BarangController;


// Halaman Login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Logout (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Semua route harus login
Route::middleware('auth')->group(function () {
    // Dashboard sesuai role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Resource
    Route::resource('menu', MenuController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('pesanan', PesananController::class);
    Route::resource('transaksi', TransaksiController::class);
     Route::resource('laporan', App\Http\Controllers\LaporanController::class)->only([
    'index', 'create', 'store', 'edit', 'update'
]);

    // PDF Routes
    Route::prefix('laporan-pdf')->name('laporan-pdf.')->group(function () {
        Route::get('/single/{id}', [LaporanPdfController::class, 'single'])->name('single');
        Route::get('/all', [LaporanPdfController::class, 'all'])->name('all');
        Route::get('/by-pelanggan/{idpelanggan}', [LaporanPdfController::class, 'byPelanggan'])->name('by-pelanggan');
    });

    // Receipt Routes
    Route::prefix('receipt')->name('receipt.')->group(function () {
        Route::get('/print/{id}', [ReceiptController::class, 'print'])->name('print');
        Route::post('/print-multiple', [ReceiptController::class, 'printMultiple'])->name('print.multiple');
        Route::get('/print-today', [ReceiptController::class, 'printToday'])->name('print.today');
        Route::get('/print-by-pelanggan/{idpelanggan}', [ReceiptController::class, 'printByPelanggan'])->name('print.by-pelanggan');
    });

    Route::resource('meja', App\Http\Controllers\MejaController::class);
    

});
