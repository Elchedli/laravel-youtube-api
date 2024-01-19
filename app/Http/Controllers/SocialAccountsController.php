<?php

namespace App\Http\Controllers;

use App\Services\KPI;
use Illuminate\Http\RedirectResponse;

class SocialAccountsController extends Controller {
    
    /**
     * @throws \Exception
     */
    public function auth($provider): RedirectResponse {
        return KPI::getDriver($provider)->authRedirect();
    }

    /**
     * @throws \Exception
     */
    public function authCallback($provider): array | string {
        return KPI::getDriver($provider)->authCB();
    }
}
