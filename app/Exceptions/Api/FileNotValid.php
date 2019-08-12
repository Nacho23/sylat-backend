<?php

namespace App\Exceptions\Api;

/**
 * Class to handle file not valid
 */
class FileNotValid extends ApiException
{
    /**
     * Construct the exception.
     *
     * @param string $resource
     */
    public function __construct(string $resource)
    {
        parent::__construct('File not valid for ' . $resource, ApiException::FILE_NOT_VALID);
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 403;
    }
}
