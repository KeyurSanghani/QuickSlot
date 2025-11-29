<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
| API Versioning Strategy:
| - URI Versioning (industry standard)
| - Current version: v1
| - All routes are prefixed with /api/v{version}
| - Example: /api/v1/users
|
*/

// API Version 1 Routes
Route::prefix('v1')
    ->name('api.v1.')
    ->group(base_path('routes/api/v1.php'));

// Future versions can be added here:
// Route::prefix('v2')
//     ->name('api.v2.')
//     ->group(base_path('routes/api/v2.php'));
