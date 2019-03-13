<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 13 Mar 2019 01:10:12 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $name
 * @property int $unit_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Unit $unit
 *
 * @package App\Models
 */
class Category extends Eloquent
{
	protected $table = 'category';

	protected $casts = [
		'unit_id' => 'int'
	];

	protected $fillable = [
		'name',
		'unit_id'
	];

	public function unit()
	{
		return $this->belongsTo(\App\Models\Unit::class);
	}

	/**
     * Filters users for parameters
     *
     * @param  array $data
     */
    public static function filterBy(array $filters = [])
    {
        $query = self::select('category.*');

        if (array_key_exists("unit_id", $filters))
        {
            $query = $query->where('category.unit_id', $filters['unit_id']);
        }

        return $query->get();
	}
}
