<?php

namespace App\Http\Controllers;
use App\Services\KPI;

class SocialAccountsController extends Controller
{
    public function auth($provider)
    {
        return KPI::getDriver($provider)->authRedirect();
    }

    public function authCallback($provider)
    {
        $data = KPI::getDriver($provider)->authCB();
        return $data;
    }
}
