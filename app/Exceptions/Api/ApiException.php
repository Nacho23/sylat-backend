<?php

namespace App\Exceptions\Api;

use Exception;

/**
 * Class to group API specific exceptions
 */
abstract class ApiException extends Exception
{
    const INTERNAL_ERROR = 1;
    const COLLECTION_NOT_FOUND = 2;
    const RESOURCE_NOT_FOUND = 3;
    const INVALID_PARAMETER = 4;
    const AUTH_FAILURE = 5;
    const AUTHORIZATION_INVALID = 6;
    const TOKEN_INVALID = 7;
    const TOKEN_EXPIRED = 8;
    const RESOURCE_ALREADY_EXISTS = 9;
    const MAX_ALLOWED_REACHED = 10;
    const RESOURCE_ALREADY_DELETED = 11;
    const NOT_OWNER = 12;
    const NOT_ACTIVE_CUSTOMER = 13;
    const NOT_ALLOWED_INPUT = 14;
    const NOT_ALLOWED_EXTENSION = 15;
    const ENTITY_HAS_CHILD = 16;
    const NOT_ALLOWED_ACCOUNT_PLAN_TYPE = 17;
    const RESOURCE_HAS_CONTEXT = 18;
    const CORRELATIVE_NOT_DEFINED = 19;
    const CORRELATIVE_DATES_NOT_MATCH = 20;
    const NOT_ALLOWED_DELETE = 21;
    const FILE_NOT_VALID = 22;
    const ACCOUNTING_ENTRIES_NOT_CONFIGURED = 23;
    const NOT_ALLOWED_OPERATION = 24;

    /**
     * Get status code
     *
     * @return int
     */
    public function getHttpStatusCode() : int
    {
        return 500;
    }
}
