<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SliderItem
 * 
 * @property int $id
 * @property int $slider_id
 * @property string $path
 * @property string|null $title
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Slider $slider
 *
 * @package App\Models
 */
class SliderItem extends Model
{
	protected $table = 'slider_items';

	protected $casts = [
		'slider_id' => 'int'
	];

	protected $fillable = [
		'slider_id',
		'path',
		'title',
		'description'
	];

	public function slider()
	{
		return $this->belongsTo(Slider::class);
	}
}
