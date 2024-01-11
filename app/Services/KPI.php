<?php

namespace App\Services;

use App\Services\Google\Google;
use App\Services\Google\Youtube\Youtube;
use Exception;

class KPI
{
    public static ?KPI $INSTANCE = null;

    public static function getInstance($newOne = false): static
    {
        if ($newOne) {
            return new static();
        }
        if (!self::$INSTANCE || get_class(self::$INSTANCE) != __CLASS__) {
            self::$INSTANCE = new static();
        }
        return self::$INSTANCE;
    }

    /**
     * @throws Exception
     */
    public static function getDriver($name, $newOne = false): Google
    {
        $n = trim(strtolower($name));
        if ($n == 'google') $driver = Google::getInstance($newOne);
        else throw new Exception(sprintf('Unsupported social driver %s', $name));
        return $driver;
    }

    /**
     * @throws Exception
     */
    public function authCB()
    {
        throw new Exception('Abstract method call');
    }

    /**
     * @throws Exception
     */
    public function authRedirect()
    {
        throw new Exception('Abstract method call');
    }
}
