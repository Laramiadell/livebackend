<?php

use Illuminate\Http\Request;
use \App\Http\Controllers\MerchandiseController;
use \App\Http\Controllers\AuthController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware'=>'auth:api'], function() {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/merchandises/search', [MerchandiseController::class, 'search']);
    Route::post('/merchandises', [MerchandiseController::class, 'store']);
    Route::get('/merchandises', [MerchandiseController::class, 'index']);

    Route::group(['middleware'=>'owner'], function() {
        Route::get('/merchandises/{merchandise}', [MerchandiseController::class, 'show']);
        Route::put('/merchandises/{merchandise}', [MerchandiseController::class, 'update']);
        Route::delete('/merchandises/{merchandise}', [MerchandiseController::class, 'destroy']);
    });
});

