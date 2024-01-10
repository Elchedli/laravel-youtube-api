<?php

namespace App\Services\Google;

use App\GoogleUser;
use App\Services\Google\Auth;
use App\Services\Google\Youtube\Youtube;
use App\Services\KPI;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class Google extends KPI
{

    use Auth;

    private $youtube;

    function __construct()
    {
        $this->youtube = new Youtube();
    }

    public function getYoutube()
    {
        return $this->youtube;
    }

    public function Service($serviceChoice)
    {
        return match ($serviceChoice) {
            'youtube' => $this->youtube,
            //Add analytics after
        };
    }

    /* TODO 
        After login/registration this function is called and it serves to get google account data so we can finish registion easily 
        or it takes id so it can fetch account details from database
    */
    function registerFlow($encryptedPayload)
    {
        $payload = json_decode(Crypt::decryptString($encryptedPayload))->payload;

        $user = $payload->user;
        //with the user information we gonna include the refresh token too
        $refresh_token = $payload->refreshToken;


        return (object) ['refreshToken' => $refresh_token, 'getAccessToken' => ($this->getUserAccessToken($refresh_token))['access_token']] ;
        try {
            //Create new user by unique id
            $user = GoogleUser::create([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'thumbnailURL' => $user->picture,
                'refreshToken' => $refresh_token
            ]);
        } catch (QueryException $e) {
            //See in the database if user exist
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();
            //TODO Whenever we see a new error we change this
            return match (intval($errorCode)) {
                23000 => 'The user already exists in the database',
                default => "newError $errorMessage",
            };
        }

        return "user is registred!";



        //TODO Register should be stateless but login and confirmation via email should not be stateless 





        // $url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics&mine=true&access_token=' . $access_token;
        // info("access token $access_token");
    }



    private function getAllUsersAuth()
    {

    }
    
    //TODO Need to do this function before Google Analytics
    private function getUserAccessToken($refresh_token)
    {

        $response = Http::asForm()
            ->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
            ]);

        return $response->successful() ? ($response->json())['access_token'] : 'Cannot retrieve Token'; 
    }
}
