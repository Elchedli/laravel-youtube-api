<?php

namespace App\Models\Google;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleUser extends Model {
    use HasFactory;

    protected $fillable = [
        'googleX_id',
        'name',
        'email',
        'thumbnailURL',
        'refreshToken'
    ];

    public function youtubeChannels(){
        return $this->hasMany(YoutubeChannel::class);
    }
}
