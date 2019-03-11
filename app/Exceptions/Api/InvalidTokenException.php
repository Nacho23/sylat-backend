<?php

namespace App\Exceptions\Api;

/**
 * Class to handle invalid tokens
 */
class InvalidTokenException extends ApiException
{
    /**
     * Construct the exception.
     *
     */
    public function __construct()
    {
        parent::__construct('Invalid token', ApiException::TOKEN_INVALID);
	}

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 403;
    }
}
