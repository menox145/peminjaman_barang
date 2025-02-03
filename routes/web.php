<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/', function () {
    return view('pinjam.index', [
        'title' => 'Home',
        'peminjaman' => App\Models\Peminjaman::with(['barang', 'user'])->latest()->get(),
        'barangs' => App\Models\Barang::where('stok', '>', 0)->get()
    ]);
})->middleware('guest');

Route::get('/about', function () {
    return view('welcome');
})->middleware('auth');

// Public borrowing form - no auth required
Route::get('/pinjam/form', [PinjamController::class, 'create'])->name('pinjam.create');
Route::post('/pinjam/store', [PinjamController::class, 'store'])->name('pinjam.store');

// Auth routes
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

// Admin routes
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'store']);
    Route::get('/dashboard/{id}', [DashboardController::class, 'show']);
    Route::get('/dashboard/{id}/edit', [DashboardController::class, 'edit']);
    Route::put('/dashboard/{id}', [DashboardController::class, 'update']);
    Route::delete('/dashboard/{id}', [DashboardController::class, 'destroy']);

    // Admin borrowing management routes
    Route::get('/pinjam', [PinjamController::class, 'index'])->name('pinjam.index');
    Route::get('/pinjam/{pinjam}', [PinjamController::class, 'show'])->name('pinjam.show');
    Route::post('/pinjam/{pinjam}/return', [PinjamController::class, 'return'])->name('pinjam.return');
    Route::delete('/pinjam/{pinjam}', [PinjamController::class, 'destroy'])->name('pinjam.destroy');
});
