<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
class YoutubeController extends Controller
{
    protected $apiKey;
    protected $youtubeEndPoint;

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
        $this->youtubeEndPoint = config('services.youtube.endpoint');
    }

    public function analytics()
    {
    }

    //This controller will help us get all videos/shorts/recorder live videos in a channel
    public function profile()
    {
        $channelName = 'ooredootn';
        $channelData = $this->getChannelData($channelName);
        $playlistId = $channelData->items[0]->contentDetails->relatedPlaylists->uploads;
        $channelVideos = $this->getAllVideos($playlistId);
        return $channelVideos;
    }

    //this function get the basic information of a channel,the most important parts are statistics(viewCount,SubscriberCounts...)
    // In contentDetails that we added from $part we gonna get uploads id which give a playlist containing all videos/shorts/recorded lives in the channel
    protected function getChannelData($forUsername)
    {
        $part = 'snippet,id,statistics,contentDetails';
        $url = "$this->youtubeEndPoint/channels?part=$part&forUsername=$forUsername&key=$this->apiKey";
        $response = Http::get($url);
        $channelInfo = json_decode($response);
        File::put(storage_path() . '/app/public/channel.json', $response->body());
        return $channelInfo;
    }

    // We have a limit of 1.000.000 quotas per day
    // Using the playlistId that we got from getChannelData object we use youtube API playlist function because it uses the cheapest searching cost (1 quota)
    // Since we have 50 max results maximum per request we use a parameter in the url called nextPageToken, we can a portion of the data each request until we fully get all of them
    protected function getAllVideos($playlistId)
    {
        $part = 'snippet,id';
        //Max resutls can't surpass 50.
        $maxResults = 50;
        $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$playlistId&token=''&maxResults=$maxResults&key=$this->apiKey";
        $response = Http::get($url);
        $partVideoPlaylist = json_decode($response);
        $nextPageToken = $partVideoPlaylist->nextPageToken;
        $tableofvideos = $partVideoPlaylist->items;
        info('url : ' . $url . "\n nextPageToken : " . $nextPageToken . "\n tableofVideos : \n");
        for ($i = 0; $i < 10; $i++) {
            $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$playlistId&token=$nextPageToken&maxResults=$maxResults&key=$this->apiKey";
            $response = Http::get($url);
            $partVideoPlaylist = json_decode($response);
            $nextPageToken = $partVideoPlaylist->nextPageToken;
            array_push($tableofvideos, $partVideoPlaylist->items);
            info('url : ' . $url . "\n nextPageToken : " . $nextPageToken . "\n tableofVideos : \n");
        }
        // while (isset($partVideoPlaylist->nextPageToken)) {
        //     $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$playlistId&token=$nextPageToken&maxResults=$maxResults&key=$this->apiKey";
        //     $response = Http::get($url);
        //     $partVideoPlaylist = json_decode($response);
        //     $nextPageToken = $partVideoPlaylist->nextPageToken;
        //     array_push($tableofvideos, $partVideoPlaylist->items);
        //     info('url : ' . $url . "\n nextPageToken : " . $nextPageToken . "\n tableofVideos : \n");
        // }

        return $tableofvideos;
    }
    // protected function getAllVideos($playlistId) {
    //     $part = 'snippet,id';
    //     // Max results can't surpass 50.
    //     $maxResults = 50;
    //     $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$playlistId&token=''&maxResults=$maxResults&key=$this->apiKey";
    //     $response = Http::get($url);
    //     $partVideoPlaylist = json_decode($response);

    //     // Check if the response was successful
    //     if (!$partVideoPlaylist || !isset($partVideoPlaylist->nextPageToken)) {
    //         // Handle the error, e.g., log it and return an empty array
    //         return [];
    //     }

    //     $nextPageToken = $partVideoPlaylist->nextPageToken;
    //     $tableofvideos = $partVideoPlaylist->items;
    //     info("url : ".$url."\n nextPageToken : ".$nextPageToken."\n tableofVideos : \n");

    //     for ($i=0; $i < 10; $i++) {
    //         $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$playlistId&token=$nextPageToken&maxResults=$maxResults&key=$this->apiKey";
    //         $response = Http::get($url);
    //         $partVideoPlaylist = json_decode($response);

    //         // Check if the response was successful
    //         if (!$partVideoPlaylist || !isset($partVideoPlaylist->nextPageToken)) {
    //             // Handle the error, e.g., log it and break the loop
    //             break;
    //         }

    //         $nextPageToken = $partVideoPlaylist->nextPageToken;
    //         // Use array_merge instead of array_push to merge arrays correctly
    //         $tableofvideos = array_merge($tableofvideos, $partVideoPlaylist->items);
    //         info("url : ".$url."\n nextPageToken : ".$nextPageToken."\n tableofVideos : \n");
    //     }
    //     while ($nextPageToken) {
    //         $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$playlistId&token=$nextPageToken&maxResults=$maxResults&key=$this->apiKey";
    //         $response = Http::get($url);
    //         $partVideoPlaylist = json_decode($response);

    //         // Check if the response was successful
    //         if (!$partVideoPlaylist || !isset($partVideoPlaylist->nextPageToken)) {
    //             // Handle the error, e.g., log it and break the loop
    //             break;
    //         }

    //         $nextPageToken = $partVideoPlaylist->nextPageToken;
    //         // Use array_merge instead of array_push to merge arrays correctly
    //         $tableofvideos = array_merge($tableofvideos, $partVideoPlaylist->items);
    //         info("url : ".$url."\n nextPageToken : ".$nextPageToken."\n tableofVideos : \n");
    //     }

    //     return $tableofvideos;
    // }

    // we get a table of video ID's with getAllVideos that we gonna use to filter category of videos (shorts,videos,live records) and gettings statistics for each video (comments,likes,views...)
    protected function getVideosContent($tableVideosIDs)
    {
        $part = 'snippet,contentDetails,statistics,localizations';
        // $maxResults = 50;
        $url = "$this->youtubeEndPoint/videos?part=$part&id=$tableVideosIDs&key=$this->apiKey";
        $response = Http::get($url);
        return json_decode($response);
    }
}
