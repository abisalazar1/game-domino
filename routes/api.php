<?php


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


Route::post('register', 'RegisterController@store');
Route::post('login', 'LoginController@store');


Route::middleware('auth:api')->group(function () {
    Route::get('auth', 'AuthController@show');
    Route::post('games/{game}/turns/skip', 'GameTurnController@skip');
    Route::post('games/{game}/turns/draw', 'GameTurnController@draw');
    Route::apiResource('games', 'GameController')->only(['index','store','show']);
    Route::apiResource('games.turns', 'GameTurnController')->only(['store']);
});
