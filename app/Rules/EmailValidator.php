<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Rules\CleanableInterface;

class EmailValidator implements Rule, CleanableInterface
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public static function clean($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : null;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return self::clean($value) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email field has incorrect format';
    }
}
