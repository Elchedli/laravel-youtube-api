<?php

namespace App\Http\Controllers;
use App\Services\KPI;

class SocialAccountsController extends Controller
{
    public function auth($provider)
    {
        return \App\Services\KPI::getDriver($provider)->authRedirect();
    }

    public function authCallback($provider)
    {
        $data = KPI::getDriver($provider)->authCB();
    }
}
