<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 06 Mar 2019 21:09:47 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\AuthenticatorTrait;
use App\Models\UuidColumnInterface;
use App\Models\UuidColumnTrait;
use App\Models\Unit;

/**
 * Class User
 * 
 * @property int $id
 * @property string $uuid
 * @property int $account_id
 * @property string $first_name
 * @property string $last_name
 * @property int $rut
 * @property string $rut_dv
 * @property string $address_street
 * @property string $address_number
 * @property string $address_department
 * @property string $address_town
 * @property string $phone_landline
 * @property string $phone_mobile
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Account $account
 * @property \Illuminate\Database\Eloquent\Collection $rols
 *
 * @package App\Models
 */
class User extends Eloquent implements UuidColumnInterface
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use AuthenticatorTrait;
	use UuidColumnTrait;

	protected $table = 'user';

	protected $casts = [
		'account_id' => 'int',
		'rut' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'uuid',
		'account_id',
		'first_name',
        'last_name',
        'email',
		'rut',
        'rut_dv',
        'unit_id',
		'address_street',
		'address_number',
		'address_department',
		'address_town',
		'phone_landline',
		'phone_mobile',
		'is_active'
	];

	public function account()
	{
		return $this->belongsTo(\App\Models\Account::class);
    }

    public function unit()
	{
		return $this->belongsTo(\App\Models\Unit::class);
	}

	public function rols()
	{
		return $this->belongsToMany(\App\Models\Rol::class, 'user_rol')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
    }

	/**
     * Filters users for parameters
     *
     * @param  array $data
     * @return LengthAwarePaginator
     */
    public static function filterBy(array $filters = []) : LengthAwarePaginator
    {
        $query = self::select('user.*');

        if (array_key_exists("is_admin", $filters))
        {
            if ($filters['is_admin'] == 'true')
            {
                $query = $query->where('user.is_admin', 1);
            }

            if ($filters['is_admin'] == 'false')
            {
                $query = $query->where('user.is_admin', 0);
            }
        }

        if (array_key_exists("is_deleted", $filters))
        {
            if ($filters['is_deleted'] == 'true')
            {
                $query = $query->where('user.deleted_at', '<>', null);
            }

            if ($filters['is_deleted'] == 'false')
            {
                $query = $query->where('user.deleted_at', null);
            }
		}

		if (array_key_exists("type", $filters))
		{
			if ($filters['type'] === 'godfather')
			{
				$query = $query->join('user_rol', 'user.id', '=', 'user_rol.user_id')
				->select('user.*')
				->where('user_rol.rol_id', '4');
			}
			else if ($filters['type'] === 'godson')
			{
				$query = $query->join('user_rol', 'user.id', '=', 'user_rol.user_id')
				->select('user.*')
				->where('user_rol.rol_id', '3');
			}
        }

        if (array_key_exists("unit_id", $filters))
        {
            $query = $query->where('user.unit_id', $filters['unit_id']);
        }

        return $query->paginate(config('app.paginate_size'));
	}

	/**
     * Get an invitation by the given value
     *
     * @param  string $email
     * @throws InvalidParametersException If the username is not email
     * @return mixed User|null
     */
    public static function findByEmail(string $email)
    {
        $query = self::select();

        if (self::isEmail($email))
        {
            $query = $query->where('email', $email);
        }
        else
        {
            throw new InvalidParametersException(['email' => 'Must be a valid email']);
        }

        return $query->first();
	}

    /**
     * Encrypt password
     *
     * @param  string $password
     * @return string
     */
    public static function hashPassword(string $password) : string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
