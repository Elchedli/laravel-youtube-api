<?php

namespace App\Http\Controllers;
use App\Services\KPI;
use Illuminate\Support\Facades\Http;

class SocialAccountsController extends Controller
{
    /**
     * @throws \Exception
     */
    public function auth($provider)
    {
        return KPI::getDriver($provider)->authRedirect();
    }

    /**
     * @throws \Exception
     */
    public function authCallback($provider): array
    {
        return KPI::getDriver($provider)->authCB();
        // return Crypt::decryptString($data['data']);
    }
}
