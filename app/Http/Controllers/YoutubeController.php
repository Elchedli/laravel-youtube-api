<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


function areAllValuesUnique(array $array) {
    return count($array) === count(array_unique($array));
}

class YoutubeController extends Controller
{
    private $apiKey;
    private $youtubeEndPoint;

    

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
        $this->youtubeEndPoint = config('services.youtube.endpoint');
    }

    
    public function testphp(){
    }

    //This controller will help us get all videos/shorts/recorder live videos in a channel
    public function profile()
    {
        $idChannel = 'UCvqUz4adCLEpGyQjWXvcK_w';
        $channelData = $this->getChannelData($idChannel);
        $playlistId = $channelData->items[0]->contentDetails->relatedPlaylists->uploads;
        $channelVideos = $this->getAllVideos($playlistId);
        // return $channelVideos;
        
        // Jeb2PJ2tvXc => short | o3PqMxYIDH4 => normal video
        return $this->getVideosContent($channelVideos);
    }

    //this function get the basic information of a channel,the most important parts are statistics(viewCount,SubscriberCounts...)
    // In contentDetails that we added from $part we gonna get uploads id which give a playlist containing all videos/shorts/recorded lives in the channel
    protected function getChannelData($idChannel)
    {
        $part = 'snippet,id,statistics,contentDetails';
        $url = "$this->youtubeEndPoint/channels?part=$part&id=$idChannel&key=$this->apiKey";
        $response = Http::get($url);
        return json_decode($response);
    }

    // We have a limit of 1.000.000 quotas per day
    // Using the playlistId that we got from getChannelData object we use youtube API playlist function because it uses the cheapest searching cost (1 quota)
    // Since we have 50 max results maximum per request we use a parameter in the url called nextPageToken, we can a portion of the data each request until we fully get all of them
    protected function getAllVideos($playlistId)
    {
        $part = 'snippet,id';
        $maxResults = 50;

        $allVideos = [];
        $nextPageToken = '';
            
        while (isset($nextPageToken)) {
            $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$playlistId&pageToken=$nextPageToken&maxResults=$maxResults&key=$this->apiKey"; // Use pageToken instead of token
            $body = json_decode(Http::get($url));
            $nextPageToken = optional($body)->nextPageToken;
            $allVideos = array_merge($allVideos, $body->items);
        }
        
        $allvideosids = array_map(fn($singleVideo) => $singleVideo->snippet->resourceId->videoId, $allVideos);
        return $allvideosids;
        
    }


    // Jeb2PJ2tvXc normally short
    // o3PqMxYIDH4 normally normal video
    // we get a table of video ID's with getAllVideos that we gonna use to filter category of videos (shorts,videos,live records) and gettings statistics for each video (comments,likes,views...)
    protected function getVideosContent($tableVideosIDs)
    {
        $part = 'snippet,contentDetails,statistics,player,liveStreamingDetails';
        $allVideos = [];
        while(!empty($tableVideosIDs)){
            $videoTable = array_splice($tableVideosIDs, 0, 50);
            info("videoTable size : ".count($videoTable));
            $url = "$this->youtubeEndPoint/videos?part=$part&id=".implode(',',$videoTable)."&key=$this->apiKey";
            $body = json_decode(Http::get($url));
            $allVideos = array_merge($allVideos, $body->items);
        }
        return $allVideos;
    }
}
