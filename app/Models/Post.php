<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 31 Mar 2019 05:29:43 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Post
 * 
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $body
 * @property int $category_id
 * @property int $user_sender_id
 * @property int $user_receiver_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Category $category
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Post extends Eloquent
{
	protected $table = 'post';

	protected $casts = [
		'category_id' => 'int',
		'user_sender_id' => 'int',
		'user_receiver_id' => 'int'
	];

	protected $fillable = [
		'uuid',
		'title',
		'body',
		'category_id',
		'user_sender_id',
		'user_receiver_id'
	];

	public function category()
	{
		return $this->belongsTo(\App\Models\Category::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_sender_id');
	}
}
