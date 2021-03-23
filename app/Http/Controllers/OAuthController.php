<?php

namespace App\Http\Controllers;

use App\Models\OAuthProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Exceptions\EmailTakenException;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        config([
            'services.google.redirect' => route('oauth.callback')
        ]);   
    }

    public function callback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        $user = $this->findOrCreateUser($user);
        $this->guard()->login($user);
        return $this->sendLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        return redirect('/rooms');
    }

    public function redirect() {
        return Socialite::driver('google')
            ->with(['hd' => 'cam.ac.uk'])
            ->redirect();
    }

    public function findOrCreateUser($user) {
        $oauthProvider = OAuthProvider::where('provider', 'google')
            ->where('provider_user_id', $user->getId())
            ->first();

        if ($oauthProvider) {
            $oauthProvider->update([
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken
            ]);

            return $oauthProvider->user;
        }

        if (User::where('email', $user->getEmail())->exists()) {
            throw new EmailTakenException;
        }

        return $this->createUser($user);
    }

    /**
     * @param  \Laravel\Socialite\Contracts\User $sUser
     * @return \App\Models\User
     */
    protected function createUser($sUser)
    {
        $user = User::create([
            'name' => $sUser->getName(),
            'email' => $sUser->getEmail(),
            'email_verified_at' => now(),
        ]);

        $user->oauthProviders()->create([
            'provider' => 'google',
            'provider_user_id' => $sUser->getId(),
            'access_token' => $sUser->token,
            'refresh_token' => $sUser->refreshToken,
        ]);

        return $user;
    }
}
