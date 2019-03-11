<?php

namespace App\Exceptions\Api;

use App\Exceptions\ErrorsDetailsInterface;
use App\Exceptions\ErrorsDetailsTrait;

/**
 * Class to handle invalid parameter exceptions
 */
class InvalidParametersException extends ApiException implements ErrorsDetailsInterface
{
    use ErrorsDetailsTrait;

    /**
     * @var array List of errors by [key => error description, ...]
     */
    protected $errors = [];

    /**
     * Construct the exception.
     *
     * @param array $errors List of parameter errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;

        parent::__construct('Invalid parameter(s)', ApiException::INVALID_PARAMETER);
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 400;
    }
}
