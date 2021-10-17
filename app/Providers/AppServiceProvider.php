<?php

namespace App\Providers;

use App\Http\Resources\RoomResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        RoomResource::withoutWrapping();
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }        
    }
}
