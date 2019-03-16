<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 16 Mar 2019 18:12:08 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class QuestionProperty
 * 
 * @property int $id
 * @property int $question_id
 * @property string $property
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Question $question
 *
 * @package App\Models
 */
class QuestionProperty extends Eloquent
{
	protected $casts = [
		'question_id' => 'int'
	];

	protected $fillable = [
		'question_id',
		'property',
		'value'
	];

	public function question()
	{
		return $this->belongsTo(\App\Models\Question::class);
	}
}
