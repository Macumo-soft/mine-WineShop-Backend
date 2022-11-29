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
Route::post('/Auth/login', [AuthController::class, "login"]);
Route::get('/Auth/logout', [AuthController::class, "logout"]);
Route::post('/Auth/registerUser', [AuthController::class, "registerUser"]);
Route::post('/Auth/deregisterUser', [AuthController::class, "deregisterUser"])->middleware('auth:sanctum');

/**
 * WineController
 */
Route::get('/Wine/getWineList', [WineController::class, 'getWineList']);
Route::get('/Wine/getWineDetail', [WineController::class, 'getWineDetail']);

/**
 * ShoppingController
 */
Route::get('/Shopping/getCartList', [ShoppingController::class, 'getCartList'])->middleware('auth:sanctum');
Route::post('/Shopping/addItem', [ShoppingController::class, 'addItem'])->middleware('auth:sanctum');
Route::post('/Shopping/updateItem', [ShoppingController::class, 'updateItem'])->middleware('auth:sanctum');
Route::post('/Shopping/deleteItem', [ShoppingController::class, 'deleteItem'])->middleware('auth:sanctum');
Route::post('/Shopping/confirmOrder', [ShoppingController::class, 'confirmOrder'])->middleware('auth:sanctum');

/**
 * ReviewController
 */
Route::post('/Review/createReview', [ReviewController::class, 'createReview'])->middleware('auth:sanctum');
Route::post('/Review/updateReview', [ReviewController::class, 'updateReview'])->middleware('auth:sanctum');
Route::post('/Review/deleteReview', [ReviewController::class, 'deleteReview'])->middleware('auth:sanctum');

// Route::group(['middleware' => ['logger']], function () {
//     Route::get('/test/hoge', function() {
//         echo "hoge";
//     });

//     Route::get('/test/fuga', function() {
//         echo "fuga";
//     });
// });
