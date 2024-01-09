<?php

namespace App\Services;

use App\Services\Google\Google;
use App\Services\Google\Youtube\Youtube;

class KPI
{
    public $NAME = null;
    public static $INSTANCE = null;

    public static function getInstance($newOne = false)
    {
        if ($newOne) {
            return new static();
        }
        if (!self::$INSTANCE || get_class(self::$INSTANCE) != __CLASS__) {
            self::$INSTANCE = new static();
        }
        return self::$INSTANCE;
    }
    
    public static function getDriver($name, $newOne = false)
    {
        $n = trim(strtolower($name));
        if ($n == 'google') $driver = Google::getInstance($newOne);
        else throw new \Exception(sprintf('Unsupported social driver %s', $name));
        return $driver;
    }

    public function authCB()
    {
        throw new \Exception('Abstract method call');
    }
    
    public function authRedirect()
    {
        throw new \Exception('Abstract method call');
    }
}
