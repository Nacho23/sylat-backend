<?php

namespace App\Exceptions;

interface ErrorsDetailsInterface
{
    /**
     * Get the error list
     *
     * @return array
     */
    public function getErrors() : array;
}