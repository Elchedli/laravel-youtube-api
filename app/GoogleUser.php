<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'name', 
        'email', 
        'thumbnailURL', 
        'refreshToken'
    ];

    public function googleUser()
    {
    }
}
