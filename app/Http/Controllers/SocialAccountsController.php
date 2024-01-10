<?php

namespace App\Http\Controllers;
use App\Services\KPI;
use Illuminate\Support\Facades\Http;

class SocialAccountsController extends Controller
{
    public function auth($provider)
    {
        return KPI::getDriver($provider)->authRedirect();
    }

    public function authCallback($provider)
    {
        return KPI::getDriver($provider)->authCB();
        // return Crypt::decryptString($data['data']);
    }
}
