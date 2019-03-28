<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 27 Mar 2019 20:57:51 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class UserRelationship
 * 
 * @property int $id
 * @property int $user_godfather_id
 * @property int $user_godson_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class UserRelationship extends Eloquent
{
	protected $table = 'user_relationship';

	protected $casts = [
		'user_godfather_id' => 'int',
		'user_godson_id' => 'int'
	];

	protected $fillable = [
		'user_godfather_id',
		'user_godson_id'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_godson_id');
	}
}
