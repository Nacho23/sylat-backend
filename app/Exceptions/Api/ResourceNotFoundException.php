<?php

namespace App\Exceptions\Api;

/**
 * Class to handle resource not found resource
 */
class ResourceNotFoundException extends ApiException
{
    /**
     * Construct the exception.
     *
     * @param string   $resource   Resource identifier
     */
    public function __construct(string $resource)
    {
        parent::__construct($resource . ' it\'s not a valid resource', ApiException::RESOURCE_NOT_FOUND);
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 404;
    }
}
