<?php

namespace App\Utils\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ToObject implements CastsAttributes {
 
    public function get($model, $key, $value, $attributes) {
        return json_decode($value);
    }

    public function set($model, $key, $value, $attributes) {
        return json_encode($value);
    }
}
