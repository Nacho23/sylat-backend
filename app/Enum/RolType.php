<?php

namespace App\Enum;

/**
 * Contract to define type of book
 */
interface RolType
{
    const GODSON = 'godson';
    const GODFATHER = 'godfather';
    const ALLOWED = [self::GODSON, self::GODFATHER];
}