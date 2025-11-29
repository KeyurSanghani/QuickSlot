<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Web\Booking\BookingController;
use App\Http\Controllers\Web\Service\ServiceController;
use App\Http\Controllers\Web\WorkingHour\WorkingHourController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Public Booking Routes
Route::prefix('bookings')->name('bookings.')->controller(BookingController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(DashboardController::class)->prefix('dashboard')->as('dashboard.')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    // Admin: Booking Management
    Route::prefix('admin/bookings')->name('admin.bookings.')->middleware('permission:view-booking')->controller(BookingController::class)->group(function () {
        Route::get('/', 'manage')->name('manage');
    });

    // Admin: Service Management
    Route::prefix('admin/services')->name('admin.services.')->middleware('permission:view-service')->controller(ServiceController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    // Admin: Working Hours Management
    Route::prefix('admin/working-hours')->name('admin.working-hours.')->middleware('permission:view-working-hour')->controller(WorkingHourController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
