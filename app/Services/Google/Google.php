<?php

namespace App\Services\Google;
use App\Services\Google\Auth;
use App\Services\Google\Youtube\Youtube;
use App\Services\KPI;
class Google extends KPI {

    use Auth;

    private $youtube;

    function __construct() {
        $this->youtube = new Youtube();
    }

    public function getYoutube() {
        return $this->youtube;
    } 

    public function Service($serviceChoice) {
        return match($serviceChoice){
            'youtube' => $this->youtube,
            //Add analytics after
        };
    }

    /* TODO 
        After login/registration this function is called and it serves to get google account data so we can finish registion easily 
        or it takes id so it can fetch account details from the internet
        should also include a database management so it can register the refresh_token in the database
    */
    function registerFlow($access_token)
    {

        //TODO Enregistre l'utilisateur avec son username,GoogleRefreshToken (verification id pour bien s'assurer qu'il est unique) dés son premier Auth
        
        //from the request you can get the name (pseudo), database : pseudo as id | Refresh_Token

        // Ajout d'un Modal qui contient le 
        
        //Notif Register should be stateless but login and confirmation via email 
        // Login should be with a session 





        $url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics&mine=true&access_token=' . $access_token;
        info("access token $access_token");
        // $data = json_decode(Http::get($url));
        // return $data;
    }


    //TODO Need to do this function before Google Analytics
    private function getUserAccessToken($user)
    {

        //Database is basically a modal variable in Laravel so it's an easy access, get Refresh token and return AccessToken
        return "verifiedTokenThatWorkfromDatabase"; 

        
        
        // test if it's null else test existing Token in variable
        
        // if Token is expired  - Code to get new Token with refresh Token in the database.


        //


        
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
