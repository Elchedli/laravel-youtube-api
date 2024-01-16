<?php

namespace App\Models\Google;

use App\Utils\Casts\ToObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeChannel extends Model {
    use HasFactory;

    // protected $fillable = [
    //     'channel_id',
    //     'googleX_id',
    //     'channel_info',
    //     'videos_infoTable',
    //     'analytics_info'
    // ];
    protected $casts = [
        'channel_info' => ToObject::class,
        'videos_infoTable' => ToObject::class,
        'analytics_info' => ToObject::class
    ];
    
    public function googleUser(){
        return $this->belongsTo(googleUser::class);
    }
}
