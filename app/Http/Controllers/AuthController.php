<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;

//TODO remove this file when you don't need it anymore

class AuthController extends Controller {
    
    public function redirectToGoogle(): RedirectResponse {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse {
        /**
         * @disregard P1009 Undefined type
         */
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->user();
        Auth::login($googleUser);

        return redirect(RouteServiceProvider::HOME);
    }
}
