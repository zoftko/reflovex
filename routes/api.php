<?php

use App\Http\Controllers\Api\Health;
use App\Http\Controllers\Api\Measurement;
use App\Http\Controllers\Api\SessionController;
use App\Http\Middleware\AuthenticateBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::name('api.')->middleware(AuthenticateBoard::class)->group(function () {
    Route::apiResource('health', Health::class);
    Route::apiResource('session', SessionController::class);
    Route::apiResource('measurement', Measurement::class);
});
