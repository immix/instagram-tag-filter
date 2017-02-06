<?php
/**
 * User: Christian Augustine
 * Date: 12/30/16
 * Time: 11:33 AM
 */

namespace App\Helpers;

class Env
{
    /**
     * Returns a value from the .env file, or throws an Exception if it is not found
     * @param $env
     * @return mixed
     * @throws \Exception
     */
    public static function required($env)
    {
        $value = env($env, false);
        if ($value === false) {
            throw new \Exception("$env not set in .env");
        }

        return $value;
    }
}
