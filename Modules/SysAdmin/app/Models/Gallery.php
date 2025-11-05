<?php

namespace Modules\SysAdmin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class Gallery
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
 * @property Collection|GalleryItem[] $gallery_items
 * @property Collection|SliderItem[] $slider_items
 *
 * @package App\Models
 */
class Gallery extends Model
{
	protected $table = 'galleries';

	protected $casts = [
		'status' => 'int'
	];

	protected function status(): Attribute
	{
		return Attribute::make(
			set: fn (int $value) => $value ?? 1,
			//get: fn (int $value) => $this->statuses[$value]
		);
	}

	protected function setNameAttribute($value)
	{
		$this->attributes['name'] = $value;
		$this->attributes['slug'] = Str::slug($value);
	}

	protected $fillable = [
		'name',
		'slug',
		'description',
		'status',
		'thumbnail'
	];

	public function scopeActive(Builder $query)
	{
		return $query->where('status', 1);
	}

	public function scopeOrderBy(Builder $query)
	{
		$query->orderBy("id", "DESC");
	}

	public function gallery_items()
	{
		return $this->hasMany(GalleryItem::class);
	}
}
