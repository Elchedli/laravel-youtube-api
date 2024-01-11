<?php

namespace App\Services\Google;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Laravel\Socialite\Facades\Socialite;

trait Auth
{
    public function authRedirect()
    {
        $provider = 'google';
        $googlepath = 'https://www.googleapis.com/auth';
        $scopes = ["$googlepath/yt-analytics.readonly", "$googlepath/yt-analytics-monetary.readonly", "$googlepath/youtubepartner-channel-audit"];
        /**
         * @disregard P1009 Undefined type
         */
        $d = Socialite::driver($provider)->stateless();
        $d->redirectUrl(secure_url(route('api.authCallback', ['provider' => $provider])));
        $d->scopes($scopes);
        $d->with(['access_type' => 'offline', 'prompt' => 'consent select_account']);
        return $d->redirect();
    }

    public function authCB(): array
    {
        $provider = 'google';
        /**
         * @disregard P1009 Undefined type
         */
        $d = Socialite::driver($provider)->stateless();
        $d->redirectUrl(secure_url(route('api.authCallback', ['provider' => $provider])));
        $p = ['type' => $provider, 'payload' => $d->user()];

        // File::put(storage_path(). '/app/public/userDetails.json',json_encode($p));
        return [
            'response' => 200,
            'userIsRegistered' => $this->registerFlow(Crypt::encryptString(json_encode($p))),
        ];
    }
}
