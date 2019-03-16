<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 16 Mar 2019 18:28:59 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Date
 * 
 * @property int $id
 * @property \Carbon\Carbon $date
 * @property int $question_id
 * 
 * @property \App\Models\Question $question
 * @property \Illuminate\Database\Eloquent\Collection $news
 *
 * @package App\Models
 */
class Date extends Eloquent
{
	protected $table = 'date';
	public $timestamps = false;

	protected $casts = [
		'question_id' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'date',
		'question_id'
	];

	public function question()
	{
		return $this->belongsTo(\App\Models\Question::class);
	}

	public function news()
	{
		return $this->hasMany(\App\Models\News::class);
	}
}
