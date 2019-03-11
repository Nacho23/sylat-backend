<?php

namespace App\Exceptions\Api;

/**
 * Class to handle Authorization errors
 */
class AuthorizationException extends ApiException
{
    /**
     * Construct the exception.
     *
     */
    public function __construct()
    {
        parent::__construct('Authorization failure', ApiException::AUTHORIZATION_INVALID);
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 403;
    }
}
