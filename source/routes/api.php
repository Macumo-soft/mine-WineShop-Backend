<?php

use App\Http\Controllers\WineController;
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

Route::get('/wine', [WineController::class, 'index']);
Route::get('/wine/getWineList', [WineController::class, 'getWineList']);
Route::get('/wine/getWineDetail', [WineController::class, 'getWineDetail']);