<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\User\ProfileController as UserProfileController;

Route::get('/', fn () => view('auth.login'));

// -----------------------
// ✅ Auth Routes
// -----------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// -----------------------
// ✅ Redirect dashboard by role
// -----------------------
Route::get('/dashboard', function () {
    if (!Auth::check()) return redirect()->route('login');

    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');

// -----------------------
// ✅ Profile Routes
// -----------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -----------------------
// ✅ Admin Routes
// -----------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::get('/password', [AdminProfileController::class, 'editPassword'])->name('admin.password');
    Route::get('/settings', [AdminProfileController::class, 'settings'])->name('admin.settings');
    Route::put('/password', [AdminProfileController::class, 'updatePassword'])->name('admin.password.update');                        

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/ruang', RuangController::class)->names('admin.ruang');
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('admin.booking.index');
    Route::get('/booking/{id}/detail', [AdminBookingController::class, 'detail'])->name('admin.booking.detail');
    Route::post('/booking/{id}/batal', [AdminBookingController::class, 'reject'])->name('admin.bookings.reject');
    Route::resource('/karyawan', KaryawanController::class)->names('admin.karyawan');
    Route::get('/karyawan/{id}/detail', [KaryawanController::class, 'detail'])->name('admin.karyawan.detail');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
});

// -----------------------
// ✅ User Routes
// -----------------------
Route::middleware(['auth', 'role:karyawan'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // profil
    Route::get('/profile', [UserProfileController::class, 'profile'])->name('user.profile');
    Route::get('/password', [UserProfileController::class, 'editPassword'])->name('user.password.edit');
    Route::get('/settings', [UserProfileController::class, 'settings'])->name('user.settings');
    Route::put('/password', [UserProfileController::class, 'updatePassword'])->name('user.password.update');

    // Booking
    Route::get('bookings/create/{ruang}', [UserBookingController::class, 'create'])->name('booking.create');
    Route::resource('/bookings', UserBookingController::class);

    // Jadwal milik user (jadwal pribadi)
    Route::resource('/jadwal', JadwalController::class)
        ->names('user.jadwal')
        ->only(['index', 'show', 'destroy']);

    Route::get('user/jadwal/riwayat', [JadwalController::class, 'riwayat'])->name('user.jadwal.riwayat');

    // Jadwal berdasarkan ruangan
    Route::get('/ruang/{ruang}/jadwal', [UserBookingController::class, 'jadwal'])->name('jadwal.ruang');

    Route::get('/booking-success', function () {
        return view('user.booking.success');
    })->name('user.booking.success');

});

require __DIR__ . '/auth.php';
