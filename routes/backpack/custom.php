<?php

use Illuminate\Support\Facades\Route;
// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    // Route::redirect('login', '/admin');
    Route::redirect('logout', '/oauth/logout');
    Route::crud('band', 'BandCrudController');
    Route::crud('ballot', 'BallotCrudController');
    Route::crud('perk', 'PerkCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('location', 'LocationCrudController');
    Route::crud('room', 'RoomCrudController');
    Route::crud('comment', 'CommentCrudController');
    Route::crud('image', 'ImageCrudController');
}); // this should be the absolute last line of this file