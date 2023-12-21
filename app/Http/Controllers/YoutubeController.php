<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class YoutubeController extends Controller
{
    public function index(){
        $videoLists = $this->_videoLists('Laravel chat');
        return $videoLists;
    }

    public function results(){
        
    }

    public function watch(){
       
    }

    protected function _videoLists($keywords){
        $part = 'snippet';
        $country = 'BD';
        $apiKey = config('services.youtube.api_key');
        $maxResults = 12;
        $youtubeEndPoint = config('services.youtube.search_endpoint');
        $type = 'video,playlist,channel';
        $url = "$youtubeEndPoint?part=$part&maxResults=$maxResults&regionCode=$country&key=$apiKey&q=$keywords";
        $response = Http::get($url);
        $results = json_decode($response);
        
        // We will create a json file to see our response 
        File::put(storage_path(). '\app\public\results.json',$response->body());
        return $results;
    }
}
