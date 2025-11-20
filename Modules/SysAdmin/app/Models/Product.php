<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
	protected $table = 'product';

	public $timestamps = true;
	protected $dateFormat = 'U';

	public static $statuses = [
		0 => 'Delete',
		1 => 'Published',
		2 => 'Draft',
	];

	protected $casts = [
		'created_at' => 'integer',
		'updated_at' => 'integer',
		'type' => 'int',
		'is_featured' => 'int',
		'sort_order' => 'int',
		'status' => 'int',
		'hits' => 'int',
		'product_category' => 'int',
		'sub_product_category' => 'int',
		'slider' => 'int',
		'order' => 'int',
	];

	protected $fillable = [
		'title',
		'slug',
		'keywords',
		'short_description',
		'description',
		'sku',
		'type',
		'is_featured',
		'video',
		'catalog',
		'thumb',
		'sort_order',
		'status',
		'hits',
		'product_category',
		'sub_product_category',
		'slider',
		'order',
	];

	protected static function boot()
	{
		parent::boot();

		static::creating(function ($model) {
			// slug from title if empty
			if (empty($model->slug) && !empty($model->title)) {
				$model->slug = Str::slug($model->title);
			}

			// order default 0 if null
			if (is_null($model->order)) {
				$model->order = 0;
			}
		});

		static::updating(function ($model) {
			// regenerate slug if title changed or slug empty
			if ($model->isDirty('title') || empty($model->slug)) {
				$model->slug = Str::slug($model->title);
			}

			// still ensure order has a value
			if (is_null($model->order)) {
				$model->order = 0;
			}
		});
	}

	protected function serializeDate(\DateTimeInterface $date): string
	{
		return $date->getTimestamp(); // store as UNIX int
	}

	public function category()
	{
		return $this->belongsTo(ProductCategory::class, 'product_category', 'id');
	}

	public function subCategory()
	{
		return $this->belongsTo(ProductCategory::class, 'sub_product_category', 'id');
	}
}
