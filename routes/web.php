<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\User\JadwalController;
use App\Http\Controllers\User\BookingController as UserBookingController;

Route::get('/', fn () => view('auth.login'));

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Redirect dashboard by role
Route::get('/dashboard', function () {
    if (!Auth::check()) return redirect()->route('login');

    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/ruang', RuangController::class)->names('admin.ruang');
    Route::get('/booking', [AdminBookingController::class, 'adminIndex'])->name('admin.booking.index');
    Route::resource('/karyawan', KaryawanController::class)->names('admin.karyawan');
    Route::get('/karyawan/{id}/detail', [KaryawanController::class, 'detail'])->name('admin.karyawan.detail');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
});

// User Routes
Route::middleware(['auth', 'role:karyawan'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('bookings/create/{ruang}', [UserBookingController::class, 'create'])->name('booking.create');

    Route::resource('/bookings', UserBookingController::class);

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
});

require __DIR__.'/auth.php';
