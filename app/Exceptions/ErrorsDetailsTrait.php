<?php

namespace App\Exceptions;

trait ErrorsDetailsTrait
{
    /**
     * {@inheritDoc}
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
}