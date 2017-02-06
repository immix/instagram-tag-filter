<?php

namespace App\Exceptions\Instagram;

/**
 * User: Christian Augustine
 * Date: 12/30/16
 * Time: 11:57 AM
 */
class InvalidAuthenticationCodeException extends \Exception
{
    public function __construct(\Exception $previous = null)
    {
        parent::__construct("Matching code was not found or was already used", ErrorCodes::INVALID_AUTHENTICATION_CODE, $previous);
    }
}
