<?php

use App\Http\Controllers\BallotController;
use App\Http\Controllers\BandController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PerkController;
use App\Http\Controllers\RoomController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/rooms', RoomController::class);
Route::apiResource('/perks', PerkController::class);
Route::apiResource('/bands', BandController::class);
Route::apiResource('/locations', LocationController::class);
Route::apiResource('/ballots', BallotController::class);
