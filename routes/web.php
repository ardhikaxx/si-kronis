<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pasien;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Dokter;
use App\Http\Controllers\Perawat;

// Auth routes (login, register, logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Pasien routes
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [Pasien\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/konsultasi', [Pasien\BookingController::class, 'index'])->name('konsultasi.index');
    Route::get('/konsultasi/create', [Pasien\BookingController::class, 'create'])->name('konsultasi.create');
    Route::post('/konsultasi', [Pasien\BookingController::class, 'store'])->name('konsultasi.store');
    Route::get('/konsultasi/{id}', [Pasien\BookingController::class, 'show'])->name('konsultasi.show');
    Route::get('/riwayat', [Pasien\RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [Pasien\RiwayatController::class, 'show'])->name('riwayat.show');
    Route::get('/riwayat/export/pdf', [Pasien\RiwayatController::class, 'exportPdf'])->name('riwayat.export-pdf');
    Route::get('/resep', [Pasien\ResepController::class, 'index'])->name('resep.index');
    Route::get('/resep/{id}', [Pasien\ResepController::class, 'show'])->name('resep.show');
    Route::post('/resep/{id}/refill', [Pasien\ResepController::class, 'requestRefill'])->name('resep.refill');
    Route::get('/resep/refill', [Pasien\ResepController::class, 'myRefills'])->name('resep.refills');
    Route::get('/profil', [Pasien\ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [Pasien\ProfilController::class, 'update'])->name('profil.update');
    Route::post('/lab/upload', [Pasien\LabController::class, 'upload'])->name('lab.upload');
    Route::get('/chat', [Pasien\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{dokter}', [Pasien\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{dokter}', [Pasien\ChatController::class, 'store'])->name('chat.store');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', Admin\UserController::class);
    Route::resource('dokter', Admin\DokterController::class);
    Route::resource('konsultasi', Admin\KonsultasiController::class);
    Route::resource('obat', Admin\ObatController::class);
    Route::resource('template-resep', Admin\PrescriptionTemplateController::class);
    Route::get('/riwayat-medis', [Admin\RiwayatMedisController::class, 'index'])->name('riwayat-medis.index');
    Route::get('/riwayat-medis/{patient}', [Admin\RiwayatMedisController::class, 'show'])->name('riwayat-medis.show');
    Route::get('/laporan', [Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [Admin\LaporanController::class, 'export'])->name('laporan.export');
});

// Dokter routes
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [Dokter\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jadwal', [Dokter\JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [Dokter\JadwalController::class, 'store'])->name('jadwal.store');
    Route::put('/jadwal/{id}', [Dokter\JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [Dokter\JadwalController::class, 'destroy'])->name('jadwal.destroy');
    Route::get('/konsultasi', [Dokter\KonsultasiController::class, 'index'])->name('konsultasi.index');
    Route::get('/konsultasi/{id}', [Dokter\KonsultasiController::class, 'show'])->name('konsultasi.show');
    Route::put('/konsultasi/{id}', [Dokter\KonsultasiController::class, 'update'])->name('konsultasi.update');
    Route::resource('resep', Dokter\ResepController::class);
    Route::get('/chat', [Dokter\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{pasien}', [Dokter\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{pasien}', [Dokter\ChatController::class, 'store'])->name('chat.store');
});

// Perawat routes
Route::middleware(['auth', 'role:perawat'])->prefix('perawat')->name('perawat.')->group(function () {
    Route::get('/dashboard', [Perawat\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/booking', [Perawat\BookingController::class, 'index'])->name('booking.index');
    Route::put('/booking/{id}/confirm', [Perawat\BookingController::class, 'confirm'])->name('booking.confirm');
    Route::put('/booking/{id}/cancel', [Perawat\BookingController::class, 'cancel'])->name('booking.cancel');
    Route::post('/lab/upload', [Perawat\LabController::class, 'upload'])->name('lab.upload');
});

// Redirect after login based on role
Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->getRoleNames()->first();
        return match($role) {
            'pasien'  => redirect()->route('pasien.dashboard'),
            'admin'   => redirect()->route('admin.dashboard'),
            'dokter'  => redirect()->route('dokter.dashboard'),
            'perawat' => redirect()->route('perawat.dashboard'),
            default   => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});
