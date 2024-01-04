<?php

namespace App\Services\Google;

use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Facades\Socialite;

trait Auth
{
    public function authRedirect()
    {
        $provider = 'google';
        $googlepath = "https://www.googleapis.com/auth";
        $scopes = ["$googlepath/yt-analytics.readonly", "$googlepath/yt-analytics-monetary.readonly", "$googlepath/userinfo.profile"];
        // $scopes = ['openid', 'profile', 'email']; // Adjust scopes as needed
        $d = Socialite::driver($provider)->stateless();
        $d->redirectUrl(secure_url(route('api.authCallback', ['provider' => $provider])));
        $d->scopes($scopes);
        $d->with(['access_type' => 'offline', 'prompt' => 'consent select_account']);
        return $d->redirect();
    }

    public function authCB()
    {
        $provider = 'google';
        $d = Socialite::driver($provider)->stateless();
        $d->redirectUrl(secure_url(route('api.authCallback', ['provider' => $provider])));
        $p = ['type' => $provider, 'payload' => $d->user()];
        // dd($p);
        return [
            'data' => Crypt::encryptString(json_encode($p)),
            'pages' => $this->getPages(data_get($p, 'payload.token')),
            'name' => data_get($p, 'payload.name'),
        ];
    }
}