<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 12 Mar 2019 03:16:18 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\UuidColumnInterface;
use App\Models\UuidColumnTrait;

/**
 * Class Unit
 * 
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class Unit extends Eloquent implements UuidColumnInterface
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use UuidColumnTrait;

	protected $table = 'unit';

	protected $fillable = [
		'uuid',
		'name',
		'code'
	];

	public function categories()
	{
		return $this->hasMany(\App\Models\Category::class);
	}

	public function messages()
	{
		return $this->hasMany(\App\Models\Message::class);
	}

	public function news()
	{
		return $this->hasMany(\App\Models\News::class);
	}

	public function questions()
	{
		return $this->hasMany(\App\Models\Question::class);
	}

	public function users()
	{
		return $this->hasMany(\App\Models\User::class);
	}

	/**
     * Filters users for parameters
     *
     * @param  array $data
     * @return LengthAwarePaginator
     */
    public static function filterBy(array $filters = []) : LengthAwarePaginator
    {
        $query = self::select('unit.*');

        return $query->paginate(config('app.paginate_size'));
	}
}
