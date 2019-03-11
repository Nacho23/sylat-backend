<?php

namespace App\Models;

trait AuthenticatorTrait
{
    /**
     * Test if the given value is an email
     *
     * @param string $value
     * @return boolean
     */
    public static function isEmail(string $value) : bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

}