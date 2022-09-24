<?php

use App\Http\Controllers\WineController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * AuthController
 */
Route::post('/auth/login', [AuthController::class, "login"]);
Route::get('/auth/logout', [AuthController::class, "logout"]);
Route::post('/auth/registerUser', [AuthController::class, "registerUser"]);
Route::post('/auth/deregisterUser', [AuthController::class, "deregisterUser"]);

/**
 * WineController
 */
Route::get('/wine/getWineList', [WineController::class, 'getWineList']);
Route::get('/wine/getWineDetail', [WineController::class, 'getWineDetail']);

/**
 * ReviewController
 */
Route::get('/review/createReview', [ReviewController::class, 'createReview']);
Route::post('/review/updateReview', [ReviewController::class, 'updateReview'])->middleware('auth:sanctum');
Route::get('/review/deleteReview', [ReviewController::class, 'deleteReview']);