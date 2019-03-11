<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 06 Mar 2019 21:09:47 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class UserRol
 * 
 * @property int $id
 * @property int $rol_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Rol $rol
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class UserRol extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'user_rol';

	protected $casts = [
		'rol_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'rol_id',
		'user_id'
	];

	public function rol()
	{
		return $this->belongsTo(\App\Models\Rol::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}
