<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Activity routes
 */
Route::prefix('activities')->group(function () {
    Route::post('/', [ ActivityController::class, 'getEventsByDateRange' ]);
    Route::post('/upload', [ ActivityController::class, 'uploadRoster' ]);

});

/**
 * Flight routes
 */
Route::prefix('flights')->group(function () {
    Route::get('/next-week', [ ActivityController::class, 'getFlightsNextWeek' ]);
    Route::post('/from', [ ActivityController::class, 'getFlightsFromLocation' ]);
});

/**
 * Standby routes
 */
Route::prefix('standbys')->group(function () {
    Route::get('/next-week', [ ActivityController::class, 'getStandbyEventsNextWeek' ]);
});

