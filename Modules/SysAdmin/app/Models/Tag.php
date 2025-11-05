<?php



namespace Modules\SysAdmin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

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
class Tag extends Model implements Transformable
{
	use TransformableTrait;
	protected $table = 'tags';

	protected $fillable = [
		'name',
		'slug'
	];
}
