<?php

namespace App\Services\Google\Youtube\APIFetching;

use Illuminate\Support\Facades\Http;


//TODO change functions to private by adding private function instead of just function
trait YoutubeDataAPI
{
     // this function get the basic information of a channel,the most important parts are statistics(viewCount,SubscriberCounts...)
    // In contentDetails that we added from $part we gonna get uploads id which give a playlist containing all videos/shorts/recorded lives in the channel
    function getChannelData($idChannel)
    {
        $part = 'snippet,id,statistics';
        $url = "$this->youtubeEndPoint/channels?part=$part&id=$idChannel&key=$this->apiKey";
        return json_decode(Http::get($url));
    }

    //** Those are looping functions that uses a lot of quotas, there are consecutive in order */


    function getAllVideosFiltered($channelID)
    {
        
        $types = ['videos','shorts','live'];
        //Array_combine help so it can replicate the value as key instead of 0,1 as array values so array_map becomes easy
        $allVideosFiltered = array_combine($types, array_map(fn ($type) => $this->getVideoPlaylistByType($type,$channelID),$types));

        //change the array to object
        return $allVideosFiltered;
    }
    


    // we get a table of video ID's with getAllVideos that contains more informations about each video like (comments,likes,views...)
    function getVideosContent($tableVideosIDs)
    {
        $part = 'snippet,contentDetails,statistics,player,liveStreamingDetails';
        $allVideos = [];
        while (!empty($tableVideosIDs)) {
            $videoTable = array_splice($tableVideosIDs, 0, 50);
            $url = "$this->youtubeEndPoint/videos?part=$part&id=" . implode(',', $videoTable) . "&key=$this->apiKey";
            $body = json_decode(Http::get($url));
            $allVideos = array_merge($allVideos, $body->items);
        }
        return $allVideos;
    }

     // We have a limit of 10.000 quotas per day
    // Using the channelID that we got from getChannelData object we use youtube API playlist function because it uses the cheapest searching cost (1 quota)
    // Since we have 50 max results maximum per request we use a parameter in the url called nextPageToken, we can a portion of the data each request until we fully get all of them
    function getVideoPlaylistByType($type, $channelID)
    {
        $part = 'snippet,id';
        $maxResults = 50;

        $allVideos = [];
        $nextPageToken = '';

        $channelID = match($type){
            'shorts' => str_replace('UC','UUSH',$channelID),
            'videos' => str_replace('UC','UULF',$channelID),
            'live' => str_replace('UC','UULV',$channelID)
        };

        while (isset($nextPageToken)) {
            $url = "$this->youtubeEndPoint/playlistItems?part=$part&playlistId=$channelID&pageToken=$nextPageToken&maxResults=$maxResults&key=$this->apiKey";
            $body = json_decode(Http::get($url));
            $nextPageToken = optional($body)->nextPageToken;
            $allVideos = array_merge($allVideos, $body->items ?? []);
        }

        $allVideosIDs = array_map(fn($singleVideo) => $singleVideo->snippet->resourceId->videoId, $allVideos);

        return !empty($allVideosIDs) ? $this->getVideosContent($allVideosIDs) : null;
    }
}
