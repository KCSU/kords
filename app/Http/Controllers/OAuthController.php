<?php

namespace App\Http\Controllers;

use App\Models\OAuthProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function __construct()
    {
        config([
            'services.google.redirect' => route('oauth.callback')
        ]);
    }

    /**
     * OAuth2 callback route after login.
     */
    public function callback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        // Check the returned account is really a @cam.ac.uk account.
        $info = $user->getRaw();
        $isCambridge = str_ends_with(strtolower($info['email'] ?? ''), '@cam.ac.uk')
            && ($info['email_verified'] ?? false) === true
            && ($info['hd'] ?? null) === 'cam.ac.uk';
        abort_unless($isCambridge, 403, 'Please sign in with your Cambridge account.');

        $user = $this->findOrCreateUser($user);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * OAuth2 redirect to Raven auth provider.
     */
    public function redirect() {
        return Socialite::driver('google')
            ->with(['hd' => 'cam.ac.uk'])
            ->scopes(['openid'])
            ->redirect();
    }

    /**
     * Login or Register a user based on OAuth info.
     */
    public function findOrCreateUser($sUser) {
        $oauthProvider = OAuthProvider::where('provider', 'google')
            ->where('provider_user_id', $sUser->getId())
            ->first();

        if ($oauthProvider) {
            return $oauthProvider->user;
        }
        $user = User::firstOrCreate(
            ['email' => $sUser->getEmail()],
            ['name' => $sUser->getName(), 'email_verified_at' => now()],
        );
        $user->oauthProviders()->create([
            'provider' => 'google',
            'provider_user_id' => $sUser->getId(),
        ]);

        return $user;
    }
}
