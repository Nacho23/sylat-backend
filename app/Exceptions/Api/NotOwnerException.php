<?php

namespace App\Exceptions\Api;

/**
 * Class to handle not owner entity errors
 */
class NotOwnerException extends ApiException
{
    /**
     * Constructs the exception
     *
     * @param string $owner     Owner info
     * @param string $resource  Resource info
     */
    public function __construct(string $owner, string $resource)
    {
        parent::__construct($owner . ' it\'s not the owner of the resource: ' . $resource, ApiException::NOT_OWNER);
    }
}
