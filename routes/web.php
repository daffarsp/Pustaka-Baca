<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\KunjunganController as AdminKunjunganController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\KunjunganController as MahasiswaKunjunganController;
use App\Http\Controllers\Mahasiswa\BukuController as MahasiswaBukuController;

// Redirect root ke login
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/mahasiswa/dashboard');
        }
    }
    return redirect('/login');
});

// Auth Routes
Auth::routes();

// Home redirect
Route::get('/home', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/mahasiswa/dashboard');
        }
    }
    return redirect('/login');
})->name('home');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Users Management
    Route::resource('users', UserController::class);
    
    // Buku Management
    Route::resource('buku', BukuController::class);
    
    // Peminjaman Management
    Route::resource('peminjaman', PeminjamanController::class);
    Route::post('peminjaman/{peminjaman}/pengembalian', [PeminjamanController::class, 'pengembalian'])
        ->name('peminjaman.pengembalian');
    
    // Kunjungan Management
    Route::get('kunjungan', [AdminKunjunganController::class, 'index'])->name('kunjungan.index');
    Route::get('kunjungan/{kunjungan}', [AdminKunjunganController::class, 'show'])->name('kunjungan.show');
    Route::post('kunjungan/{kunjungan}/checkout', [AdminKunjunganController::class, 'checkout'])
        ->name('kunjungan.checkout');
});

// Mahasiswa Routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
    
    // Katalog Buku & Pinjam
    Route::get('/buku', [MahasiswaBukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{buku}', [MahasiswaBukuController::class, 'show'])->name('buku.show');
    Route::post('/buku/{buku}/pinjam', [MahasiswaBukuController::class, 'pinjam'])->name('buku.pinjam');
    
    // Kunjungan
    Route::get('/checkin', [MahasiswaKunjunganController::class, 'create'])->name('kunjungan.create');
    Route::post('/checkin', [MahasiswaKunjunganController::class, 'store'])->name('kunjungan.store');
    Route::post('/checkout', [MahasiswaKunjunganController::class, 'checkout'])->name('kunjungan.checkout');
});