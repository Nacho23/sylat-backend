<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 13 Mar 2019 19:23:22 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Models\UuidColumnInterface;
use App\Models\UuidColumnTrait;

/**
 * Class News
 * 
 * @property int $id
 * @property string $uuid
 * @property string $description
 * @property int $unit_id
 * @property bool $is_active
 * @property int $date_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Date $date
 * @property \App\Models\Unit $unit
 *
 * @package App\Models
 */
class News extends Eloquent implements UuidColumnInterface
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use UuidColumnTrait;

	protected $casts = [
		'unit_id' => 'int',
		'is_active' => 'bool',
		'date_id' => 'int'
	];

	protected $fillable = [
		'uuid',
		'description',
		'unit_id',
		'is_active',
		'date_id'
	];

	public function date()
	{
		return $this->belongsTo(\App\Models\Date::class);
	}

	public function unit()
	{
		return $this->belongsTo(\App\Models\Unit::class);
	}

	/**
     * Filters news for parameters
     *
     * @param  array $data
     */
    public static function filterBy(array $filters = [])
    {
        $query = self::select('news.*');

        if (array_key_exists("unit_id", $filters))
        {
            $query = $query->where('news.unit_id', $filters['unit_id']);
        }

        return $query->get();
	}
}
