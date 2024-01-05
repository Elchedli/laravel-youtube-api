<?php

namespace App\Services\Google;
use App\Services\Google\Auth;
use App\Services\KPI;
use Illuminate\Support\Facades\Http;
class Google extends KPI {
    
    use Auth;
    
    /* TODO 
        After login/registration this function is called and it serves to get google account data so we can finish registion easily 
        or it takes id so it can fetch account details from the internet
        should also include a database management so it can register the refresh_token in the database
    */
    function getPages($access_token)
    {
        $url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics&mine=true&access_token=' . $access_token;
        info("access token $access_token");
        // $data = json_decode(Http::get($url));
        // return $data;
    }

    static function getAppAccessToken()
    {
        
        // TODO test token and refresh it while making the updates in the database (if needed)

        
        //For now access_token is a static but i need 
        // $access_token = 


        // $this->variabley;
        // $url = sprintf(
        //     'https://graph.facebook.com/%s/oauth/access_token?client_id=%s&client_secret=%s&grant_type=client_credentials',
        //     self::$graph_api_version,
        //     config('facebook.facebook_app_id'),
        //     config('facebook.facebook_app_secret')
        // );
        // $response = $this->client->get($url);
        // $response = json_decode($response->getBody(), true);
        // return $response['access_token'] ?? '';
    }
}
