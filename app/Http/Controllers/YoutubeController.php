<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

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
        $test = (object) array (
            'happy' => 'cool life'
        );
        return isset($test->sleep);
    }

    //This controller will help us get all videos/shorts/recorder live videos in a channel
    public function profile()
    {
        $idChannel = 'UCvqUz4adCLEpGyQjWXvcK_w';
        $channelData = $this->getChannelData($idChannel);
        $playlistId = $channelData->items[0]->contentDetails->relatedPlaylists->uploads;
        $channelVideos = $this->asyncGetAllVideos($playlistId);
        return $channelVideos;
    }

    //this function get the basic information of a channel,the most important parts are statistics(viewCount,SubscriberCounts...)
    // In contentDetails that we added from $part we gonna get uploads id which give a playlist containing all videos/shorts/recorded lives in the channel
    protected function getChannelData($idChannel)
    {
        $part = 'snippet,id,statistics,contentDetails';
        $url = "$this->youtubeEndPoint/channels?part=$part&id=$idChannel&key=$this->apiKey";
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

    protected function asyncGetAllVideos($playlistId)
    {
        $client = new Client();
        $part = 'snippet,id';
        $maxResults = 50;

        $allVideos = [];
        $nextPageToken = '';
            
        while (isset($nextPageToken)) {
            $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$playlistId&pageToken=$nextPageToken&maxResults=$maxResults&key=$this->apiKey"; // Use pageToken instead of token
            $promise = $client->requestAsync('GET', $url);
            $response = $promise->wait();
            $body = json_decode($response->getBody()->getContents());
            // array_push($allVideos,$body->items);
            $nextPageToken = optional($body)->nextPageToken;
            info("Previous Url : $url & New token: $nextPageToken");
            $allVideos = array_merge($allVideos, $body->items);
        }

        // for ($i = 0; $i < 4; $i++) {
        //     $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$playlistId&pageToken=$nextPageToken&maxResults=$maxResults&key=$this->apiKey"; // Use pageToken instead of token
        //     $promise = $client->requestAsync('GET', $url);
        //     $response = $promise->wait();
        //     $body = json_decode($response->getBody()->getContents());
        //     // File::put(storage_path() . "/app/public/youtube$i.json", $response->getBody()->getContents());
        //     // Append videos from the current response to the collection
        //     $allVideos = array_merge($allVideos, [$body]);
        //     info('New token: ' . optional($body)->nextPageToken);
        //     $nextPageToken = optional($body)->nextPageToken; // Update nextPageToken for the next iteration
            
        // }

        // Return all videos collected across multiple requests
        return $allVideos;
    }

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
