<?php

namespace App\Http\Controllers\FetchingData;

use App\Http\Controllers\Controller;
use App\Services\Google\Google;
class GoogleController extends Controller
{
    private Google $Google;


    public function __construct() {
        $this->Google = new Google();
    }

     //TODO make this saveIndatabase function
     //TODO make this updateAllUsers after updateUserData
    public function fetchYoutubeData(): object
    {
        $userTokens = $this->Google->getAllUsersAuth();
        return $this->Google->Service('youtube')->fetchDataAPI('give token here probably will be removed');
        return $this->Google->Service('youtube')->fetchChannelAnalytics();

        //TODO Return update succeeded if data extracted correctly
        //See if async can be better in this condition
    }



    public function testphp(){
        return $this->Google->getAllUsersAuth();
    }
    //TODO make this saveIndatabase function
    function updateUserData($user){
        // $data = $this-
        // { Refetch user Token and get user data than save the updated data if needed }
        // if everything works fine return a good message

        //Suggestion : is it better to launch a lot of requests async or a
    }



    //TODO this will be deleted after
    //This controller will help us get all videos/shorts/recorder live videos in a channel
    public function profile(): object
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
