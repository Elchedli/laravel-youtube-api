<?php

namespace App\Services\Google;

use Laravel\Socialite\Facades\Socialite;

trait Auth {

    public function authRedirect()
    {
        $provider = 'google';
        $scopes = [
            'read_insights', 'pages_read_engagement', 'email', 'public_profile',
            'instagram_basic', 'instagram_manage_insights', 'pages_manage_posts',
        ];
        $d = Socialite::driver($provider)->stateless();
        $d->redirectUrl(secure_url(route('api.authCallback', ['provider' => $provider])));
        $d->asPopup()->reRequest();
        $d->scopes($scopes);
        $d->with(['display' => 'popup', 'auth_type' => 'rerequest']);
        return $d->redirect();
    }

    public function authCB()
    {
        $provider = 'google';
        $d = Socialite::driver($provider)->stateless();
        $d->redirectUrl(secure_url(route('api.authCallback', ['provider' => $provider])));
        $p = ['type' => $provider, 'payload' => $d->user()];
        return [
            'data' => \Crypt::encryptString(json_encode($p)),
            'pages' => $this->getPages(data_get($p, 'payload.token')),
            'name' => data_get($p, 'payload.name'),
        ];
    }
}
