<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 06 Mar 2019 21:09:47 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Token
 * 
 * @property int $id
 * @property string $token
 * @property string $type
 * @property string $details
 * @property \Carbon\Carbon $created_dt
 * @property \Carbon\Carbon $expire_dt
 * @property int $user_id
 * @property \Carbon\Carbon $updated_dt
 *
 * @package App\Models
 */
class Token extends Eloquent
{
	protected $table = 'token';
	public $timestamps = false;

	protected $casts = [
		'account_id' => 'int'
	];

	protected $dates = [
		'created_dt',
		'expire_dt',
		'updated_dt'
	];

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'token',
		'type',
		'details',
		'created_dt',
		'expire_dt',
		'account_id',
		'updated_dt'
	];

	public function account()
	{
		return $this->belongsTo(\App\Models\Account::class);
	}
}
