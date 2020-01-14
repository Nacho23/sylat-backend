<?php

namespace App\Exceptions\Api;

use App\Exceptions\ErrorsDetailsInterface;
use App\Exceptions\ErrorsDetailsTrait;

/**
 * Class to handle duplicated resources
 */
class ResourceAlreadyExistsException extends ApiException implements ErrorsDetailsInterface
{
    use ErrorsDetailsTrait;
    /**
     * Construct the exception.
     *
     * @param string   $resource       Resource identifier
     * @param string   $uniqueFields   Related fields
     */
    public function __construct(string $resource, array $uniqueFields = [])
    {
        parent::__construct('El registro ya existe para ' . $resource, ApiException::RESOURCE_ALREADY_EXISTS);

        $this->errors = $uniqueFields;
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 409;
    }
}
