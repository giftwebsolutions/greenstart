<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
	protected $table = 'product_category';

	public static $statuses = [
		0 => 'Delete',
		1 => 'Published',
		2 => 'Draft',
	];

	public $timestamps = false;

	protected $casts = [
		'parent_id' => 'int',
		'sort'      => 'int',
	];

	protected $fillable = [
		'parent_id',
		'name',
		'description',
		'banner',
		'slug',
		'image',
		'sort',
		'status',
	];

	/**
	 * AUTO SLUG BEFORE SAVE/UPDATE
	 */
	protected static function boot()
	{
		parent::boot();

		// Before create
		static::creating(function ($model) {
			// Default parent_id = 0
			if (empty($model->parent_id)) {
				$model->parent_id = 0;
			}

			if (!empty($model->name)) {
				$model->slug = Str::slug($model->name);
			}
		});

		// Before update
		static::updating(function ($model) {

			// Default parent_id = 0 if empty
			if (empty($model->parent_id)) {
				$model->parent_id = 0;
			}
			
			// Only regenerate slug if name changed
			if ($model->isDirty('name')) {
				$model->slug = Str::slug($model->name);
			}
		});
	}

	/**
	 * Category relations
	 */
	public function parent()
	{
		return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
	}

	public function children()
	{
		return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
	}
}
