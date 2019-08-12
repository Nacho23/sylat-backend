<?php

namespace App\Http\InputRules;

/**
 * Class to parse names of columns of purchase and sale books to internal names
 */
class ImportUserParse
{
    public static function user()
    {
        return [
            'rut' => 'rut',
            'rut_dv' => 'rut dv',
            'first_name' => 'nombre',
            'last_name' => 'apellido',
            'email' => 'correo electrónico',
            'address_street' => 'dirección',
            'address_number' => 'numero',
            'address_department' => 'dpto',
            'address_town' => 'ciudad',
            'phone_mobile' => 'teléfono celular',
            'phone_landline' => 'teléfono fijo',
        ];
    }
}