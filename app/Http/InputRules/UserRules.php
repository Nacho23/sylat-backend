<?php

namespace App\Http\InputRules;

use App\Rules\EmailValidator;
use App\Rules\PhoneValidator;
use Illuminate\Validation\Rule;

class UserRules
{
    /**
     * Rules to insert a company
     *
     * @return void
     */
    public static function postRules()
    {
        return [
            'rut' => 'required|numeric|min:1|max:200000000',
            'rut_dv' => 'required|string|max:9',
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => ['required', 'string', new EmailValidator],
            'address_street' => 'nullable|string',
            'address_number' => 'nullable|string',
            'address_department' => 'string|nullable',
            'address_town' => 'string|nullable',
            'phone_landline' => ['string', 'nullable',  new PhoneValidator],
            'phone_mobile' => ['string', 'nullable', new PhoneValidator],
        ];
    }

    /**
     * Rules to update a company
     *
     * @return void
     */
    public static function updateRules()
    {
        return [
            'rut' => 'required|numeric|min:1|max:200000000',
            'rut_dv' => 'required|string|max:9',
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => ['required', 'string', new EmailValidator],
            'address_street' => 'nullable|string',
            'address_number' => 'nullable|string',
            'address_department' => 'string|nullable',
            'address_town' => 'string|nullable',
            'phone_landline' => ['string', 'nullable',  new PhoneValidator],
            'phone_mobile' => ['string', 'nullable', new PhoneValidator],
        ];
    }
}