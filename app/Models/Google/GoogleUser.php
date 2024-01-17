<?php

namespace App\Models\Google;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleUser extends Model {

    use HasFactory;


    //this is needed so when i seed the database for testing Eloquant will wait for for the database
    public $incrementing = false;

    //this disables created_at and modified_at
    public $timestamps = false;

    //this is used to get nested relation table youtubeChannels without using Model::with('youtubeChannels')->get();
    protected static function booted() {
        static::addGlobalScope('youtubeChannels', function (Builder $builder) {
            $builder->with('youtubeChannels');
        });
    }

    public function youtubeChannels(){
        // google_user_id is the reference of foreign key in YoutubeChannel to primary key google_id in GoogleUser
        return $this->hasMany(YoutubeChannel::class, 'google_user_id', 'google_id');
    }
}
