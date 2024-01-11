<?php

namespace App\Services\Google\Youtube;
use App\Services\Google\Youtube\APIFetching\YoutubeDataAPI;

class Youtube
{

    use YoutubeDataAPI;

    private mixed $apiKey;
    private string $youtubeEndPoint;
    private string $Token;

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
        $this->youtubeEndPoint = config('services.youtube.endpoint');
    }


    //TODO use Google Token
    //Token parameter is not needed if we gonna use $this->Token
    //This function will help us get channel details and all videos/shorts/lives in a channel
    function fetchDataAPI($token): object
    {
        $channelData = $this->getChannelData($token);
        $channelID = $channelData->items[0]->id; // this is needed if there is no id
        return (object) ['channel' => $channelData, 'videos' => $this->getAllVideosFiltered($channelID)];
    }

    function fetchChannelAnalytics($period = "max"): null
    {
        return null;
    }


    //TODO make this saveInDatabase function
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
