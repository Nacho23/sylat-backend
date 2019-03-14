<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 13 Mar 2019 19:23:16 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Date
 *
 * @property int $id
 * @property \Carbon\Carbon $date
 *
 * @property \Illuminate\Database\Eloquent\Collection $news
 *
 * @package App\Models
 */
class Date extends Eloquent
{
	protected $table = 'date';
	public $timestamps = false;

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'date'
	];

	public function news()
	{
		return $this->hasMany(\App\Models\News::class);
	}
}
