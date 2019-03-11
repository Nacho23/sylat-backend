<?php

namespace App\Exceptions\Api;

/**
 * Class to handle expired tokens errors
 */
class ExpiredTokenException extends ApiException
{
    /**
     * Construct the exception.
     *
     */
    public function __construct()
    {
        parent::__construct('Access token expired', ApiException::TOKEN_EXPIRED);
	}

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 403;
    }
}
