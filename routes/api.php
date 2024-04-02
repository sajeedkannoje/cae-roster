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
Route::prefix('activity')->name('activity.')->group(function () {
    Route::post('/', [ ActivityController::class, 'getEventsByDateRange' ])->name('get-events-by-date-range');
    Route::post('/upload', [ ActivityController::class, 'uploadRoster' ])->name('upload');

});

/**
 * Flight routes
 */
Route::prefix('flights')->name('flights.')->group(function () {
    Route::get('/next-week', [ ActivityController::class, 'getFlightsNextWeek' ])->name('next-week');
    Route::post('/from', [ ActivityController::class, 'getFlightsFromLocation' ])->name('from-location');
});

/**
 * Standby routes
 */
Route::prefix('standbys')->name('standby.')->group(function () {
    Route::get('/next-week', [ ActivityController::class, 'getStandbyEventsNextWeek' ])->name('next-week');
});

