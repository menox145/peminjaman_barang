<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterTindakanController;
use App\Http\Controllers\MasterTindakanController;


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

Route::get('/mastertindakan', function () {
    return view('cost.MasterTindakan', [
        'title' => 'Master Tindakan',
        'tindakan' => App\Models\MasterTindakan::latest()->get(),
        'peminjaman' => collect([]) // Empty collection for compatibility
    ]);
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

// Master Tindakan Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('master/tindakan', MasterTindakanController::class)->names([
        'index' => 'master.tindakan.index',
        'create' => 'master.tindakan.create',
        'store' => 'master.tindakan.store',
        'show' => 'master.tindakan.show',
        'edit' => 'master.tindakan.edit',
        'update' => 'master.tindakan.update',
        'destroy' => 'master.tindakan.destroy',
    ]);
});
Route::post('/service', [ServiceController::class, 'logout']);
