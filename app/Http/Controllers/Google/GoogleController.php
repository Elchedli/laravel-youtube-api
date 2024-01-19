<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Services\Google\Google;

class GoogleController extends Controller {
    private Google $Google;




    public function __construct() {
        $this->Google = new Google();
    }

    //TEST those are controllers functions 
    public function testphp() {
        return "hello";
        // return $this->fetchYoutubeUsersData();
    }




    
    /* This is youtube API part */


    /* TODO
        make this saveIndatabase function
        make this updateAllUsers after updateUserData
    */
    
    private function fetchYoutubeUsersData(): object {
        $google = $this->Google;
        $userTokens = $google->getAllUsersAuth();
        $youtube = $google->Service('youtube');
        //COMMENT gettype function if needed one day
        //  dd($userTokens,gettype($userTokens[0]));
        $data = $userTokens->map(fn ($user) => [
            'DataAPI' => $youtube->fetchDataAPI($user->access_token),
            'Analytics' =>  $youtube->fetchChannelAnalytics($user->access_token)
        ]);

        return $data;
        //TODO Return update succeeded if data extracted correctly
        //See if async can be better in this condition
    }

    //TODO make this saveIndatabase function
    private function saveUserData($user) {
        // { Refetch user Token and get user data than save the updated data if needed }
        // if everything works fine return a good message
    }



    //TODO this will be deleted after
    //This controller will help us get all videos/shorts/recorder live videos in a channel
    public function profile(): object {
        /*
            COMMENT when i finish i will delete those
            foot africa channel id : UCvqUz4adCLEpGyQjWXvcK_w
            my channel shidono id : UCj6cRIsQnyrWfwJX2x7S0lg
            Skoda channel  id : UCjG24cC7xIEkVtxKdhHDwtg
        */

        $idChannel = 'UCjG24cC7xIEkVtxKdhHDwtg';
        $channelData = $this->getChannelData($idChannel);
        $channelID = $channelData->items[0]->id; // this is needed if there is no id
        return (object) ['channel' => $channelData, 'videos' => $this->getAllVideosFiltered($channelID)];
    }
}
