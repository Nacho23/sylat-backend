<?php

namespace App\Exceptions\Api;

/**
 * Class to handle Authentication errors
 */
class AuthenticationException extends ApiException
{
    /**
     * Construct the exception.
     *
     */
    public function __construct()
    {
        parent::__construct('Authentication failure', ApiException::AUTH_FAILURE);
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 401;
    }
}
