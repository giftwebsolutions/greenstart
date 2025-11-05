<?php

namespace Modules\SysAdmin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Slider
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $status
 * @property string|null $thumbnail
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Slider extends Model
{
	protected $table = 'sliders';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'description',
		'status',
		'thumbnail'
	];

	public function slider_items()
	{
		return $this->hasMany(SliderItem::class, 'slider_id');
	}
}
