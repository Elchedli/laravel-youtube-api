<?php

namespace App\Http\Controllers;

use App\Services\KPI;
use App\Providers\RouteServiceProvider;

class SocialAccountsController extends Controller {
    
    /**
     * @throws \Exception
     */
    public function auth($provider): RouteServiceProvider {
        return KPI::getDriver($provider)->authRedirect();
    }

    /**
     * @throws \Exception
     */
    public function authCallback($provider): array | string {
        return KPI::getDriver($provider)->authCB();
    }
}
