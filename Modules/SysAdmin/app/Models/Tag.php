<?php



namespace Modules\SysAdmin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 *  @package Modules\SysAdmin\Models
 */
class Tag extends Model
{
		protected $table = 'tags';

	protected $fillable = [
		'name',
		'slug'
	];
}
