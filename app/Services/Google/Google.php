<?php

namespace App\Services\Google;
use App\Services\Google\Auth;
use App\Services\KPI;
use Illuminate\Support\Facades\Http;
class Google extends KPI
{
    use Auth;
    function getPages($access_token)
    {
        $url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics&mine=true&access_token=' . $access_token;
        $data = json_decode(Http::get($url));
        dd($data);
        // return json_decode(Http::get($url));
        $r = collect([]);
        // $this->getPaginatedData($url, function ($data) use (&$r) {
        //     $els = collect($data['items'] ?? [])->map(function (array $row) {
        //         $el = [];   
        //         $el['id'] = data_get($row, 'id');
        //         $el['title'] = data_get($row, 'snippet.title');
        //         $el['description'] = data_get($row, 'snippet.description');
        //         $el['thumbnail'] = data_get($row, 'snippet.thumbnails.default.url');
        //         $el['viewCount'] = data_get($row, 'statistics.viewCount');
        //         $el['subscriberCount'] = data_get($row, 'statistics.subscriberCount');
        //         $el['videoCount'] = data_get($row, 'statistics.videoCount');
        //         return $el;
        //     });
            // $r = $r->concat($els);
        // });
        return $r;
    }
}
