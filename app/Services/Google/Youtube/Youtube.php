<?php

namespace App\Services\Google\Youtube;

use App\Services\Google\Google;
use App\Services\Google\Youtube\APIFetching\YoutubeDataAPI;

class Youtube
{

    use YoutubeDataAPI;

    private $apiKey;
    private $youtubeEndPoint;
    private $Token;

    public function __construct()
    {   
        $this->apiKey = config('services.youtube.api_key');
        $this->youtubeEndPoint = config('services.youtube.endpoint');
    }


    //use Google Token 
    //This function will help us get channel details and all videos/shorts/lives in a channel
    function fetchDataAPI($token)
    {
        $channelData = $this->getChannelData($token);
        $channelID = $channelData->items[0]->id; // this is needed if there is no id
        return (object) ['channel' => $channelData, 'videos' => $this->getAllVideosFiltered($channelID)];
    }

    function fetchChannelAnalytics($period = "max")
    {
        return null;
    }


    //TODO make this saveIndatabase function
    function updateUserData($user){
        // $data = $this-
        // { Refetch user Token and get user data than save the updated data if needed }
        // if everything works fine return a good message

        //Suggestion : is it better to launch a lot of requests async or a 
    }



    //TODO make this updateAllUsers after updateUserData
    function updateAllUsers(){
        
        // Get Modal table containing all google users
        // While that userTable, give token and work with it
    }
}