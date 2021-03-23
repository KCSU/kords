<?php

namespace App\Http\Controllers;

use App\Models\OAuthProvider;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function __construct()
    {
        config([
            'services.google.redirect' => route('oauth.callback')
        ]);   
    }

    public function callback(Request $request)
    {
        //$user = Socialite::driver('google')->user();
        //...
    }

    public function redirect() {
        return Socialite::driver('google')
            ->with(['hd' => 'cam.ac.uk'])
            ->redirect();
    }
}
