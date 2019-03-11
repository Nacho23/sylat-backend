<?php

namespace App\Rules;

use App\Models\User;
use App\Rules\CleanableInterface;

interface CleanableInterface
{
    /**
     * Cleaning values
     *
     * @param mixed $value Value
     */
    public static function clean($value);
}