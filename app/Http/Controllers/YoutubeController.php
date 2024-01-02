<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Http\Services\Utils\Utilities;
use stdClass;

class YoutubeController extends Controller
{
    private $apiKey;
    private $youtubeEndPoint;

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
        $this->youtubeEndPoint = config('services.youtube.endpoint');
    }

    public function testphp(): bool
    {
        // Jeb2PJ2tvXc => short | o3PqMxYIDH4 => normal video
        $id = 'o3PqMxYIDH4';
        // $response = Http::head("https://www.youtube.com/shorts/$id");
        // info("data : ".$this->isShortVideo($id));
        return !(Utilities::isRedirection("https://www.youtube.com/shorts/$id"));
    }

    //This controller will help us get all videos/shorts/recorder live videos in a channel
    public function profile()
    {
        //foot channel id : UCvqUz4adCLEpGyQjWXvcK_w
        //my channel shidono id : UCj6cRIsQnyrWfwJX2x7S0lg
        //Skoda channel  id : UCjG24cC7xIEkVtxKdhHDwtg
        $idChannel = 'UCjG24cC7xIEkVtxKdhHDwtg';

        $channelData = $this->getChannelData($idChannel);
        $playlistId = $channelData->items[0]->contentDetails->relatedPlaylists->uploads;
        $channelVideosPartialData = $this->getAllVideos($playlistId);
        $channelVideos = $this->getVideosContent($channelVideosPartialData);
        return (object)['channel' => $channelData, 'videos' => $this->filterVideosByType($channelVideos)];
    }

    // this function get the basic information of a channel,the most important parts are statistics(viewCount,SubscriberCounts...)
    // In contentDetails that we added from $part we gonna get uploads id which give a playlist containing all videos/shorts/recorded lives in the channel
    private function getChannelData($idChannel)
    {
        $part = 'snippet,id,statistics,contentDetails';
        $url = "$this->youtubeEndPoint/channels?part=$part&id=$idChannel&key=$this->apiKey";
        return json_decode(Http::get($url));
    }

    // We have a limit of 10.000 quotas per day
    // Using the playlistId that we got from getChannelData object we use youtube API playlist function because it uses the cheapest searching cost (1 quota)
    // Since we have 50 max results maximum per request we use a parameter in the url called nextPageToken, we can a portion of the data each request until we fully get all of them
    private function getAllVideos($playlistId)
    {
        $part = 'snippet,id';
        $maxResults = 50;

        $allVideos = [];
        $nextPageToken = '';

        while (isset($nextPageToken)) {
            $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$playlistId&pageToken=$nextPageToken&maxResults=$maxResults&key=$this->apiKey";
            $body = json_decode(Http::get($url));
            $nextPageToken = optional($body)->nextPageToken;
            $allVideos = array_merge($allVideos, $body->items);
        }

        $allVideosIds = array_map(fn ($singleVideo) => $singleVideo->snippet->resourceId->videoId, $allVideos);
        return $allVideosIds;
    }

    // we get a table of video ID's with getAllVideos that we gonna use to filter category of videos (shorts,videos,live records) and gettings statistics for each video (comments,likes,views...)
    private function getVideosContent($tableVideosIDs)
    {
        $part = 'snippet,contentDetails,statistics,player,liveStreamingDetails';
        $allVideos = [];
        while (!empty($tableVideosIDs)) {
            $videoTable = array_splice($tableVideosIDs, 0, 50);
            info('videoTable size : ' . count($videoTable));
            $url = "$this->youtubeEndPoint/videos?part=$part&id=" . implode(',', $videoTable) . "&key=$this->apiKey";
            $body = json_decode(Http::get($url));
            $allVideos = array_merge($allVideos, $body->items);
        }
        return $allVideos;
    }

    private function filterVideosByType($Videos)
    {
        
        $Videos = array_filter($Videos, fn ($singleVideo) => $singleVideo->snippet->liveBroadcastContent !== "upcoming");
        // Filter conditions
        $conditions = [
            'lives' => function ($item) {
                return isset($item->liveStreamingDetails);
            },
            'shorts' => function ($item) {
                return !(Utilities::isRedirection("https://www.youtube.com/shorts/" . $item->id));
            },
        ];
    
        // Initialize $tableVideos as an object
        $tableVideos = new \stdClass();
        
        // Apply filters sequentially
        foreach ($conditions as $key => $condition) {
            $filteredData = array_filter($Videos, $condition);
            $tableVideos->$key = $filteredData; // Assign property dynamically
            $Videos = array_diff_key($Videos, $filteredData);
        }
        // dd($filteredData,$Videos,$tableVideos);
        $tableVideos->normalVideos = $Videos;
        // dd($filteredData,$Videos,$tableVideos);
        return $tableVideos;
        // make a map or filter that divides into three variables [liveStreams,Shorts,Normal videos]
        // if liveStreamingDetails exist in videos that means Api exist
    }

    
    
}
