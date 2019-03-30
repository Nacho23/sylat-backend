<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 28 Mar 2019 16:28:36 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class Message
 * 
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $unit_id
 * @property int $user_sender_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Unit $unit
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Message extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $table = 'message';

	protected $casts = [
		'unit_id' => 'int',
		'user_sender_id' => 'int'
	];

	protected $fillable = [
		'title',
		'body',
		'unit_id',
		'user_sender_id'
	];

	public function unit()
	{
		return $this->belongsTo(\App\Models\Unit::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_sender_id');
	}

	/**
     * Filters message for parameters
     *
     * @param  array $data
     * @return LengthAwarePaginator
     */
    public static function filterBy(array $filters = []) : LengthAwarePaginator
    {
        $query = self::select('message.*');

        return $query->paginate(config('app.paginate_size'));
	}
}
