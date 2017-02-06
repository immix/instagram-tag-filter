<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Returns a value from the .env file, or throws an Exception if it is not found
     * @param $env
     * @return mixed
     * @throws \Exception
     */
    protected function requiredEnv($env)
    {
        $value = env($env, false);
        if ($value === false) {
            throw new \Exception("$env not set in .env");
        }

        return $value;
    }
}
