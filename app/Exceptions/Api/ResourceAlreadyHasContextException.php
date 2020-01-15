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
        parent::__construct('El registro tiene dependencia(s) asociada(s)');
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 409;
    }
}
