<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 01 Apr 2019 02:16:34 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Models\UuidColumnInterface;
use App\Models\UuidColumnTrait;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class Answer
 *
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property string $answer
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $date
 *
 * @property \App\Models\Question $question
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Answer extends Eloquent implements UuidColumnInterface
{
	use UuidColumnTrait;

	protected $table = 'answer';

	protected $casts = [
        'user_id' => 'int'
	];

	protected $fillable = [
		'uuid',
		'type',
		'answer',
		'user_id',
		'question_id',
		'date'
	];

	public function question()
	{
		return $this->belongsTo(\App\Models\Question::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	/**
     * Filters answers for parameters
     *
     * @param  array $data
     * @return LengthAwarePaginator
     */
    public static function filterBy(array $filters = []) : LengthAwarePaginator
    {
		$query = self::select('answer.*');

		if (array_key_exists("user_id", $filters))
        {
            $query = $query->where('answer.user_id', $filters['user_id']);
		}

		if (array_key_exists("question_id", $filters))
        {
            $query = $query->where('answer.question_id', $filters['question_id']);
        }

        if (array_key_exists("date", $filters))
        {
            $query = $query->where('answer.date', $filters['date']);
        }

        if (array_key_exists('start_date', $filters) && array_key_exists('end_date', $filters))
		{
			$query = $query->whereBetween('answer.date', [$filters['start_date'], $filters['end_date']]);
		}

        return $query->paginate(config('app.paginate_size'));
	}
}
