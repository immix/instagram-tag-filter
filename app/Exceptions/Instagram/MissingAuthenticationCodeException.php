<?php

namespace App\Exceptions\Instagram;

/**
 * User: Christian Augustine
 * Date: 12/30/16
 * Time: 11:57 AM
 */
class MissingAuthenticationCodeException extends \Exception
{
    public function __construct(\Exception $previous = null)
    {
        parent::__construct("Failed to authenticate. Missing authentication code from Instagram API", ErrorCodes::MISSING_AUTHENTICATION_CODE, $previous);
    }
}
