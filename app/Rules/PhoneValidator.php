<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Rules\CleanableInterface;

class PhoneValidator implements Rule, CleanableInterface
{
    public static function clean($value)
    {
        $phone = preg_replace('/[^\p{L}\p{N}\s]/u', '', $value);
        $phone = str_replace(' ', '', $phone);
        return is_numeric($phone) ? $phone : null;
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
        return 'The phone field has incorrect format';
    }
}
