<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/bands', [ApiController::class, 'bands']);
    Route::get('/perks', [ApiController::class, 'perks']);
    Route::get('/rooms', [ApiController::class, 'rooms']);
    Route::get('/ballots', [ApiController::class, 'ballots']);
    Route::get('/locations', [ApiController::class, 'locations']);
    Route::post('/comments', [ApiController::class, 'storeComment']);
    Route::post('/images', [ApiController::class, 'storeImage']);
});
