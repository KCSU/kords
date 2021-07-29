<?php

use App\Http\Controllers\OAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/oauth', [OAuthController::class, 'redirect']);
Route::get('/oauth/callback', [OAuthController::class, 'callback'])
    ->name('oauth.callback');
Route::get('/oauth/logout', [OAuthController::class, 'logout']);
Route::middleware('guest')->get('/login', function () {
    return view('login');
})->name('login');
Route::middleware('auth')->get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');