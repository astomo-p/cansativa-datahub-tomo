<?php

use Illuminate\Support\Facades\Route;
use $MODULE_NAMESPACE$\NewAnalytics\$CONTROLLER_NAMESPACE$\NewAnalyticsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('newanalytics', NewAnalyticsController::class)->names('newanalytics');
});
