<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;


class AuthController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        Auth::login($googleUser);

        return redirect(RouteServiceProvider::HOME);
    }
}
