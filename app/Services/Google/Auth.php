<?php

namespace App\Services\Google;

use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Facades\Socialite;
trait Auth {

    public function authRedirect() {
        $provider = 'google';
        $googlepath = 'https://www.googleapis.com/auth';
        $scopes = [
            "$googlepath/yt-analytics.readonly",
            "$googlepath/yt-analytics-monetary.readonly",
            "$googlepath/youtubepartner-channel-audit"
        ];
       /** @disregard P1009 Undefined type */
        $d = Socialite::driver($provider)->stateless();
        $d->redirectUrl(secure_url(route('api.authCallback', ['provider' => $provider])));
        $d->scopes($scopes);

        //COMMENT this is might be useless , took from facebook code
        // $d->with(['access_type' => 'online', 'prompt' => 'consent select_account']);
        return $d->redirect();
    }

    public function authCB(): array {
        $provider = 'google';
        /** @disregard P1009 Undefined type */
        $d = Socialite::driver($provider)->stateless();
        $d->redirectUrl(secure_url(route('api.authCallback', ['provider' => $provider])));
        $p = ['type' => $provider, 'payload' => $d->user()];
        return [
            'response' => 200,
            'userIsRegistered' => $this->registerFlow(Crypt::encryptString(json_encode($p))),
        ];
    }
}
