<?php

use Illuminate\Support\Facades\Route;
use Modules\NewAnalytics\App\Http\Controllers\NewAnalyticsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('newanalytics', NewAnalyticsController::class)->names('newanalytics');
});
