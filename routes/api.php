<?php

use App\Http\Controllers\AuthenticateUserController;
use App\Http\Controllers\API\V1\GetWeatherController;
use App\Http\Controllers\API\V1\FavouriteController;
use App\Http\Controllers\API\V1\UserController;
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

Route::name('api.')->group(function () {

    Route::post('/authenticate-user', AuthenticateUserController::class)->middleware('throttle:authenticate-user')->name('authenticate-user');

    Route::prefix('v1')->name('v1.')->group(function () {

        Route::get('/get-weather', GetWeatherController::class)->middleware('throttle:get-weather')->name('get-weather');
        Route::apiResource('users', UserController::class)->only(['store'])->middleware('throttle:store-user');

        Route::middleware('auth:sanctum')->group(function () {
            Route::apiResource('favourites', FavouriteController::class)->only(['store']);
        });

    });

});