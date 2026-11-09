<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, AuthController, DashboardController, BookingController, AdminServiceController};

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [HomeController::class, 'services'])->name('services.index');

Route::middleware('visitor.only')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('role:customer')->name('logout');
Route::post('/admin/logout', [AuthController::class, 'logout'])->middleware('role:admin')->name('admin.logout');

Route::middleware('role:customer')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/booking/{service?}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    Route::get('/booking/{booking}/bayar', [BookingController::class, 'payForm'])->name('bookings.pay');
    Route::post('/booking/{booking}/bayar', [BookingController::class, 'payStore'])->name('bookings.pay.store');
});

Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/layanan', [AdminServiceController::class, 'index'])->name('services');
    Route::get('/booking', [BookingController::class, 'adminIndex'])->name('bookings');
    Route::post('/layanan', [AdminServiceController::class, 'store'])->name('services.store');
    Route::put('/layanan/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('/layanan/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');
    Route::patch('/booking/{booking}', [BookingController::class, 'updateStatus'])->name('bookings.update');

    Route::get('/transaksi', function () {
        return view('admin.transactions', [
            'bookings' => \App\Models\Booking::with(['customer', 'service'])
                ->whereIn('status', ['Dikonfirmasi', 'Selesai'])
                ->latest()
                ->get()
        ]);
    })->name('transactions');
});