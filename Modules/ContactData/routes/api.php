<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\ContactData\App\Http\Controllers\ContactDataController;

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
    Route::get('top-five-area-pharmacies',[ContactDataController::class,"topFiveAreaPharmacies"]);
    Route::get('top-five-purchase-pharmacies', [ContactDataController::class, "topFivePurchasePharmacies"]);
    Route::get('contact-growth', [ContactDataController::class, "contactGrowth"]);
    Route::get('top-contact-card', [ContactDataController::class, "topContactCard"]);
});

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('contactdata', fn (Request $request) => $request->user())->name('contactdata');
});
