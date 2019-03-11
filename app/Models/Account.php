<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 06 Mar 2019 21:09:47 +0000.
 */

namespace App\Models;

use App\Enum\TokenTypes;
use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Exceptions\Api\AuthenticationException;
use App\Exceptions\Api\InvalidParametersException;
use App\Exceptions\Api\ResourceNotFoundException;
use DateTimeImmutable;
use App\Models\AuthenticableInterface;
use App\Models\UuidColumnInterface;
use App\Models\ModelTimeZoneTrait;
use App\Models\AuthenticatorTrait;
use App\Models\UuidColumnTrait;
use App\Models\Token;

/**
 * Class Account
 *
 * @property int $id
 * @property string $uuid
 * @property string $email
 * @property string $password
 * @property bool $is_admin
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class Account extends Eloquent implements AuthenticableInterface, UuidColumnInterface
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use ModelTimeZoneTrait;
    use AuthenticatorTrait;
    use UuidColumnTrait;
	protected $table = 'account';

	protected $casts = [
		'is_admin' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'uuid',
		'email',
		'password',
		'is_admin'
	];

	public function users()
	{
		return $this->hasMany(\App\Models\User::class);
	}

    /**
     * Get an invitation by the given value
     *
     * @param  string $email
     * @throws InvalidParametersException If the username is not email
     * @return mixed Account|null
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
     * {@inheritDoc}
     */
    public static function authenticate(string $email, string $password): Account
    {
        $account = self::findByEmail($email);

        if (!$account)
        {
            throw new ResourceNotFoundException($email);
        }

        if (!password_verify($password, $account->password))
        {
            throw new AuthenticationException;
        }

        return $account;
	}

	/**
     * Refresh the account access token
     *
     * @return Token
     */
    public function refreshAccessToken(): Token
    {
        // Get last non expired access token
        $token = Token::where('account_id', $this->id)->
            where('type', 'access')->
            where('expire_dt', '>', gmdate('Y-m-d H:i:s'))->
            first();

        // If not exists, we crete a new one
        if (!$token)
        {
            $token = Token::create([
                'account_id' => $this->id,
                'token' => substr(md5(microtime() . $this->id), 0, 22),
                'type' => 'access',
                'expire_dt' => (new DateTimeImmutable('now UTC'))->modify('+2 weeks')->format('Y-m-d H:i:s'),
                'created_dt' => gmdate('Y-m-d H:i:s'),
            ]);
        }

        $token->expire_dt = (new DateTimeImmutable('now UTC'))->modify('+2 weeks')->format('Y-m-d H:i:s');
        $token->save();

        return $token;
	}

    /**
     * Expire the existing tokens
     *
     * @return void
     */
    public function expireTokens(string $type = TokenTypes::ACCESS)
    {
        Token::where('account_id', $this->id)->
            where('type', $type)->
            where('expire_dt', '>', gmdate('Y-m-d H:i:s'))->
            update([
                'expire_dt' => gmdate('Y-m-d H:i:s'),
            ]);
    }

	/**
     * Get the related token by the given account
     *
     * @param string $token
     * @return mixed Token|null
     */
    public function getTokenByHash(string $token)
    {
        return Account::tokens()->where('token', $token)->first();
    }

    /**
     * Get tokens relationship
     */
    public function tokens()
    {
        return $this->hasMany(\App\Models\Token::class);

    }
}
