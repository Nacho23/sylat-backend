<?php

namespace App\Exceptions\Api;

use App\Exceptions\ErrorsDetailsInterface;
use App\Exceptions\ErrorsDetailsTrait;

/**
 * Class to handle an exception of  extension file not allowed
 */
class NotAllowedExtensionException extends ApiException implements ErrorsDetailsInterface
{
    use ErrorsDetailsTrait;

    /**
     * @var array List of errors by [key => error description, ...]
     */
    protected $errors = [];

    /**
     * Construct the exception.
     *
     * @param array  $errors  List of parameter errors
     * @param string $message Error message
     */
    public function __construct(array $errors, string $message= 'Not allowed extension')
    {
        $this->errors = $errors;

        parent::__construct($message, ApiException::NOT_ALLOWED_EXTENSION);
    }

    /**
     * Get the error list
     *
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpStatusCode() : int
    {
        return 400;
    }
}
