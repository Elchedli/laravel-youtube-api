<?php

namespace App\Services\Google\Youtube;

use App\Services\Google\Google;
use App\Services\Google\Youtube\APIFetching\YoutubeDataAPI;

class Youtube extends Google
{

    use YoutubeDataAPI;

    private $apiKey;
    private $youtubeEndPoint;

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

    function fetchChannelAnalytics()
    {
        return null;
    }

}