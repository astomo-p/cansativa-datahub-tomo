<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Analytics\App\Http\Controllers\AnalyticsController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::prefix('v1')->name('api.')->group(function () {
    Route::get('analytics-data', [AnalyticsController::class,"analyticsData"]);
});

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('analytics', fn (Request $request) => $request->user())->name('analytics');
});
