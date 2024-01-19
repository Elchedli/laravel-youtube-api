<?php

namespace App\Models\Google;

use App\Utils\Casts\ToObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeChannel extends Model {
    
    use HasFactory;

    //this disables created_at and modified_at
    public $timestamps = false;

    //Instad of getting JSON data as string it convert it automatically into object 
    //If you have JSON data in channel_info for example in your database you can test using YoutubeChannel::first()->channel_info
    protected $casts = [
        'channel_info' => ToObject::class,
        'videos_infoTable' => ToObject::class,
        'analytics_info' => ToObject::class
    ];
    

    
    public function googleUser(){
        // google_id is the reference of primary key in GoogleUser to foreign key google_user_id in YoutubeChannel
        $this->belongsTo(GoogleUser::class, 'google_user_id', 'google_id');
    }
}
