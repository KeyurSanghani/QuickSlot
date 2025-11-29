<?php

use App\Http\Controllers\Api\V1\Availability\AvailabilityController;
use App\Http\Controllers\Api\V1\Booking\BookingController;
use App\Http\Controllers\Api\V1\Dropdown\DropdownController;
use App\Http\Controllers\Api\V1\Service\ServiceController;
use App\Http\Controllers\Api\V1\WorkingHour\WorkingHourController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Here are the version 1 API routes for your application. These routes
| are loaded by the RouteServiceProvider and all of them will be assigned
| to the "api" middleware group with "v1" prefix.
|
*/

Route::middleware(['web', 'api'])->group(function () {
    // DROPDOWN
    Route::controller(DropdownController::class)->group(function () {
        Route::get('/dropdown', 'getDropdown')->name('dropdown');
    });

    // AVAILABILITY - Public routes for checking availability
    Route::prefix('availability')->name('availability.')->controller(AvailabilityController::class)->group(function () {
        Route::get('/slots', 'getAvailableSlots')->name('slots');
        Route::get('/dates', 'getAvailableDates')->name('dates');
    });

    // SERVICES - Public routes for active services
    Route::get('/services/active', [ServiceController::class, 'getActiveServices'])->name('services.active');

    // BOOKINGS - Public routes for creating bookings
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

// Protected Routes - Require Authentication
Route::middleware(['web'])->group(function () {
    // SERVICE MANAGEMENT
    Route::prefix('services')->name('services.')->controller(ServiceController::class)->group(function () {
        Route::get('/', 'index')->middleware('permission:view-service')->name('index');
        Route::post('/', 'store')->middleware('permission:add-service')->name('store');
        Route::get('/{id}', 'show')->middleware('permission:view-service')->name('show');
        Route::put('/{id}', 'update')->middleware('permission:edit-service')->name('update');
        Route::patch('/{id}', 'update')->middleware('permission:edit-service');
        Route::delete('/{id}', 'destroy')->middleware('permission:delete-service')->name('destroy');
        Route::patch('/{id}/status', 'toggleStatus')->middleware('permission:edit-service')->name('status');
    });

    // WORKING HOUR MANAGEMENT
    Route::prefix('working-hours')->name('working-hours.')->controller(WorkingHourController::class)->group(function () {
        Route::get('/', 'index')->middleware('permission:view-working-hour')->name('index');
        Route::post('/', 'store')->middleware('permission:add-working-hour')->name('store');
        Route::get('/grouped', 'getGroupedByDay')->name('grouped');
        Route::get('/{id}', 'show')->middleware('permission:view-working-hour')->name('show');
        Route::put('/{id}', 'update')->middleware('permission:edit-working-hour')->name('update');
        Route::patch('/{id}', 'update')->middleware('permission:edit-working-hour');
        Route::delete('/{id}', 'destroy')->middleware('permission:delete-working-hour')->name('destroy');
        Route::patch('/{id}/status', 'toggleStatus')->middleware('permission:edit-working-hour')->name('status');
    });

    // BOOKING MANAGEMENT
    Route::prefix('bookings')->name('bookings.')->controller(BookingController::class)->group(function () {
        Route::get('/', 'index')->middleware('permission:view-booking')->name('index');
        Route::get('/upcoming', 'getUpcoming')->name('upcoming');
        Route::get('/by-date', 'getByDate')->name('by-date');
        Route::get('/{id}', 'show')->middleware('permission:view-booking')->name('show');
        Route::put('/{id}', 'update')->middleware('permission:edit-booking')->name('update');
        Route::patch('/{id}', 'update')->middleware('permission:edit-booking');
        Route::delete('/{id}', 'destroy')->middleware('permission:delete-booking')->name('destroy');
        Route::patch('/{id}/cancel', 'cancel')->middleware('permission:cancel-booking')->name('cancel');
        Route::patch('/{id}/confirm', 'confirm')->middleware('permission:confirm-booking')->name('confirm');
        Route::patch('/{id}/complete', 'complete')->middleware('permission:complete-booking')->name('complete');
    });
});
