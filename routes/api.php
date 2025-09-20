<?php

use App\Http\Controllers\MetaController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrentCompanyController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Meta (public) - sin auth para onboarding inicial
Route::get('/timezones', [MetaController::class, 'timezones']);
Route::get('/currencies', [MetaController::class, 'currencies']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/company/current', [CurrentCompanyController::class, 'current']);
    Route::get('/companies/mine', [CurrentCompanyController::class, 'mine']);
    Route::post('/company/switch', [CurrentCompanyController::class, 'switch']);
    Route::get('/company/limits', [CurrentCompanyController::class, 'limits']);
});

// Calendly Webhook
Route::post('/calendly/webhook', [App\Http\Controllers\CalendlyWebhookController::class, 'handle']); 

// Locations (countries, provinces, cities)
Route::get('/countries', [\App\Http\Controllers\LocationController::class, 'countries']);
Route::get('/provinces', [\App\Http\Controllers\LocationController::class, 'provinces']);
Route::get('/cities', [\App\Http\Controllers\LocationController::class, 'cities']);