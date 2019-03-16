<?php

namespace App\Exceptions\Api;

/**
 * Class to handle duplicated context
 */
class ResourceAlreadyHasContextException extends ApiException
{
    /**
     * Construct the exception.
     *
     * @param string   $resource Resource identifier
     * @param string   $context  Related fields
     */
    public function __construct(string $resource, string $context)
    {
        parent::__construct('Resource already have the context ' . $context .' for ' . $resource, ApiException::RESOURCE_HAS_CONTEXT);
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 409;
    }
}
