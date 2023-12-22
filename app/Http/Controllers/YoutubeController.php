<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class YoutubeController extends Controller
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
    }

    public function searchVideos()
    {
        $country = 'Tunisia';
        $videoLists = $this->_videoLists('Tunisia', $this->_countryParser($country));
        return $videoLists;
    }

    public function test()
    {
        return ['countrycode' => $this->_countryParser('United States'), 'stop' => $this->apiKey];
    }

    public function profile()
    {
    }

    public function analytics()
    {
    }

    protected function _videoLists($keywords, $country)
    {
        $part = 'snippet';
        $country = 'BD';
        $maxResults = 12;
        $youtubeEndPoint = config('services.youtube.search_endpoint');
        $type = 'video,playlist,channel';
        $url = "$youtubeEndPoint?part=$part&maxResults=$maxResults&regionCode=$country&key=$this->apiKey&q=$keywords";
        $response = Http::get($url);
        $results = json_decode($response);

        // We will create a json file to see our response
        File::put(storage_path() . '/app/public/results.json', $response->body());
        return $results;
    }

    protected function _countryParser($countryFullname)
    {

        
        $filePath = storage_path('app/public/translation/countries.json');
        
        if (File::exists($filePath)) {
            $jsonContent = File::get($filePath);
            $translations = json_decode($jsonContent, true);
        }
        info('Country : '.$filePath.'translated : '.$translations[$countryFullname]);
        return $translations[$countryFullname] | 'no countries found';
    }
}
