<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Block
 * 
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $title
 * @property string|null $icon
 * @property string|null $thumbnail
 *
 * @package App\Models
 */
class Block extends Model
{
	protected $table = 'blocks';

	protected $fillable = [
		'key',
		'value',
		'title',
		'icon',
		'thumbnail'
	];
}
