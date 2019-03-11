<?php

namespace App\Util;

use App\Exceptions\Api\InvalidParametersException;
use InvalidArgumentException;
use Illuminate\Http\Request;
use Validator;

trait VerifyTrait
{
    /**
     * Verify if the given input compliance the template rules
     *
     * @param Request|array   $input     Input to check
     * @param array           $template  Template of rules
     * @return void
     */
    public function verify($input, array $template)
    {
        if ($input instanceof Request)
        {
            $input = $input->all();
        }
        else if (is_array($input))
        {
            $input = $input;
        }
        else
        {
            throw new InvalidArgumentException;
        }

        self::verifyInput($input, $template);
    }

    /**
     * Validate the input against the rules
     *
     * @param array $input            Input to check
     * @param array $template         Template rules
     * @param bool  $throwException
     * @return void
     */
    public static function verifyInput(array $input, array $template, bool $throwException = true)
    {
        $validator = Validator::make($input, $template);

        if ($validator->fails())
        {
            $errors = [];

            foreach ($validator->errors()->toArray() as $key => $details)
            {
                $errors[$key] = implode('. ', $details);
            }

            if (!$throwException)
            {
                return $errors;
            }

            throw new InvalidParametersException($errors);
        }
    }
}