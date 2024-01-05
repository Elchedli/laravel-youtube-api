<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class YoutubeController extends Controller
{
    private $apiKey;
    private $youtubeEndPoint;

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
        $this->youtubeEndPoint = config('services.youtube.endpoint');
    }

    public function testphp()
    {
        // Jeb2PJ2tvXc => short | o3PqMxYIDH4 => normal video
        $part = 'snippet,id,statistics';
        $url = "$this->youtubeEndPoint/channels?part=$part&mine=true&key=$this->apiKey";
        return json_decode(Http::get($url));
    }

    //This controller will help us get all videos/shorts/recorder live videos in a channel
    public function profile()
    {
        //foot africa channel id : UCvqUz4adCLEpGyQjWXvcK_w
        //my channel shidono id : UCj6cRIsQnyrWfwJX2x7S0lg
        //Skoda channel  id : UCjG24cC7xIEkVtxKdhHDwtg
        $idChannel = 'UCjG24cC7xIEkVtxKdhHDwtg';
        $channelData = $this->getChannelData($idChannel);
        $channelID = $channelData->items[0]->id; // this is needed if there is no id
        return (object) ['channel' => $channelData, 'videos' => $this->getAllVideosFiltered($channelID)];
    }
    
}
