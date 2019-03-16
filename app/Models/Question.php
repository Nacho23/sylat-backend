<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 16 Mar 2019 18:11:56 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class Question
 * 
 * @property int $id
 * @property string $description
 * @property string $type
 * @property int $unit_id
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Unit $unit
 * @property \Illuminate\Database\Eloquent\Collection $question_properties
 *
 * @package App\Models
 */
class Question extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'question';

	protected $casts = [
		'unit_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'description',
		'type',
		'unit_id',
		'is_active'
	];

	public function unit()
	{
		return $this->belongsTo(\App\Models\Unit::class);
	}

	public function question_properties()
	{
		return $this->hasMany(\App\Models\QuestionProperty::class);
	}

	/**
     * Filters users for parameters
     *
     * @param  array $data
     * @return LengthAwarePaginator
     */
    public static function filterBy(array $filters = []) : LengthAwarePaginator
    {
		$query = self::select('question.*');

		if (array_key_exists("unit_id", $filters))
        {
            $query = $query->where('question.unit_id', $filters['unit_id']);
        }

        return $query->paginate(config('app.paginate_size'));
	}
}
