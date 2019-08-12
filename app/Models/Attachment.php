<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 12 Aug 2019 01:34:56 +0000.
 */

namespace App\Models;

use App\Models\UuidColumnInterface;
use App\Models\UuidColumnTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;


/**
 * Class Attachment
 * 
 * @property int $id
 * @property string $uuid
 * @property string $extension
 * @property string $file_name
 * @property string $sha
 * @property string $description
 * @property string $metadata
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Attachment extends Eloquent implements UuidColumnInterface
{
	use UuidColumnTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'attachment';

	protected $fillable = [
		'uuid',
		'extension',
		'file_name',
		'sha',
		'description',
		'metadata'
	];

	/**
	 * Get attachment filename
	 *
	 * @return string
	 */
	public function getFileName() : string
	{
		return $this->sha . '.' .$this->extension;
	}
}
