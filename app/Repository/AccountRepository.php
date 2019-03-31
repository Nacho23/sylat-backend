<?php

namespace App\Repository;

use App\Exceptions\Api\InvalidParametersException;
use App\Exceptions\Api\ResourceAlreadyExistsException;
use App\Exceptions\Api\NotAllowedInputException;
use App\Models\Account;
use App\Repository\ValidateRutTrait;
use Illuminate\Support\Facades\DB;
use Exception;

class AccountRepository
{
    use ValidateRutTrait;

    /**
     * Create a new account
     *
     * @param  array $data  Account data
     * @return Account
     */
    public static function add(array $data) : Account
    {
        try
        {
            self::assertCreateValidations($data);

            DB::beginTransaction();

            $account = Account::create([
                'email' => $data['email'],
                'password' => $data['rut'],
                'is_admin' => '0',
            ]);

            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            throw $e;
        }

        return $account;
    }

    /**
     * Assert sanity checks for creating a Account
     *
     * @param array $input  Account raw data
     * @return void
     */
    private static function assertCreateValidations(array $input)
    {
        // Verify that rut is correct
        if (!self::validateRut((int)$input['rut'], $input['rut_dv']))
        {
            throw new InvalidParametersException(['rut' => 'The rut is not valid']);
        }


        if (array_key_exists("rut", $data) && Account::where('rut', $data['rut'])->first())
        {
            throw new ResourceAlreadyExistsException("rut " . $data['rut'], ['rut' => 'Rut must be unique']);
        }

        if (array_key_exists("email", $data) && Account::where('email', $data['email'])->first())
        {
            throw new ResourceAlreadyExistsException("email " . $data['email'], ['email' => 'Email must be unique']);
        }

        // Verify that you have not associated a rut for the same custoumer
        /*if (Account::where('customer_id', $input['customer_id'])->where('rut', $input['rut'])->first())
        {
            throw new ResourceAlreadyExistsException("rut " . $input['rut'] . $input['rut_dv'], ['rut' => 'Rut must be unique']);
        }*/
    }
}
