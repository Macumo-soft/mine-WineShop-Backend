<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WineController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\ReviewController;
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
Route::post('/auth/deregisterUser', [AuthController::class, "deregisterUser"])->middleware('auth:sanctum');

/**
 * WineController
 */
Route::get('/wine/getWineList', [WineController::class, 'getWineList']);
Route::get('/wine/getWineDetail', [WineController::class, 'getWineDetail']);

/**
 * ShoppingController
 */
Route::post('/shopping/getCartList', [ShoppingController::class, 'getCartList'])->middleware('auth:sanctum');
Route::post('/shopping/updateCartList', [ShoppingController::class, 'updateCartList'])->middleware('auth:sanctum');
Route::post('/shopping/confirmOrder', [ShoppingController::class, 'confirmOrder'])->middleware('auth:sanctum');

/**
 * ReviewController
 */
Route::get('/review/createReview', [ReviewController::class, 'createReview'])->middleware('auth:sanctum');
Route::post('/review/updateReview', [ReviewController::class, 'updateReview'])->middleware('auth:sanctum');
Route::get('/review/deleteReview', [ReviewController::class, 'deleteReview'])->middleware('auth:sanctum');

// Route::group(['middleware' => ['logger']], function () {
//     Route::get('/test/hoge', function() {
//         echo "hoge";
//     });

//     Route::get('/test/fuga', function() {
//         echo "fuga";
//     });
// });
