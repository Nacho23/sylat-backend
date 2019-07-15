<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 31 Mar 2019 05:29:43 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Models\UuidColumnInterface;
use App\Models\UuidColumnTrait;
use Illuminate\Pagination\LengthAwarePaginator;

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
class Post extends Eloquent implements UuidColumnInterface
{
	use UuidColumnTrait;

	protected $table = 'post';

	protected $casts = [
		'category_id' => 'int',
		'unit_id' => 'int',
		'user_sender_id' => 'int',
		'user_receiver_id' => 'int'
	];

	protected $fillable = [
		'uuid',
		'title',
		'body',
		'is_important',
		'category_id',
		'unit_id',
		'user_sender_id',
		'user_receiver_id'
	];

	public function category()
	{
		return $this->belongsTo(\App\Models\Category::class);
	}

	public function user_sender()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_sender_id');
	}

	public function user_receiver()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_receiver_id');
	}

	public function unit()
	{
		return $this->belongsTo(\App\Models\Unit::class);
	}

	/**
     * Filters posts for parameters
     *
     * @param  array $data
     * @return LengthAwarePaginator
     */
    public static function filterBy(array $filters = []) : LengthAwarePaginator
    {
		$query = self::select('post.*')->orderBy('created_at', 'desc');

		if (array_key_exists("rol_id", $filters))
		{
			if($filters['rol_id'] == 3)
			{
				$query = $query->where('post.user_receiver_id', $filters['user_id']);
			}
			else
			{
				$query = $query->where('post.user_sender_id', $filters['user_id']);
			}
		}

		if (array_key_exists("category_id", $filters))
        {
            $query = $query->where('post.category_id', $filters['category_id']);
		}

		if (array_key_exists("unit_id", $filters))
        {
            $query = $query->where('post.unit_id', $filters['unit_id']);
		}

		if (array_key_exists("is_important", $filters))
        {
            $query = $query->where('post.is_important', 1);
        }

        return $query->paginate(config('app.paginate_size'));
	}
}
