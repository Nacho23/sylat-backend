<?php

namespace App\Models;

use App\Models\Account;

interface AuthenticableInterface
{
    /**
     * Verify that the username and password are correct
     *
     * @param string   $username
     * @param string   $password
     * @return Account
     */
    public static function authenticate(string $username, string $password) : Account;
}