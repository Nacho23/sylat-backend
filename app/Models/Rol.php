<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 06 Mar 2019 21:09:47 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Rol
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class Rol extends Eloquent
{
	protected $table = 'rol';

	protected $fillable = [
		'name'
	];

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class, 'user_rol')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}
}
