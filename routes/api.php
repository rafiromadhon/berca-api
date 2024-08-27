<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;


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

Route::middleware(['logger'])->group(function () {
    Route::group(['prefix' => 'stock'], function () {
        Route::post('create', [StockController::class, 'create']);
        Route::get('list', [StockController::class, 'list']);
        Route::get('detail/{id}', [StockController::class, 'detail']);
        Route::post('update', [StockController::class, 'update']);
        Route::get('delete/{id}', [StockController::class, 'delete']);
    });
});

