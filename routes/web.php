<?php
// routes/web.php (Updated)

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengaturanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Route untuk semua user (admin dan guru)
    Route::get('/presensi', [PresensiController::class, 'index'])->name('guru.presensi');
    Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');

    // Route khusus admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/gurus', [AdminController::class, 'gurus'])->name('admin.gurus');

        // Pengaturan sistem
        Route::get('/admin/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan');
        Route::put('/admin/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });
});
