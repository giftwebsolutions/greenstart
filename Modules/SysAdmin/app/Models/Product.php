<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\SysAdmin\Helpers\ImageUploader;

class Product extends Model
{
	protected $table = 'product';

	public $timestamps = true;

	// store timestamps as UNIX integer
	protected $dateFormat = 'U';

	public static $statuses = [
		0 => 'Delete',
		1 => 'Published',
		2 => 'Draft',
	];

	protected $casts = [
		'created_at'           => 'integer',
		'updated_at'           => 'integer',

		'type'                 => 'int',   // 1 simple, 2 variable (SYSTEM CONTROLLED)
		'is_featured'          => 'int',
		'sort_order'           => 'int',
		'status'               => 'int',
		'hits'                 => 'int',
		'product_category'     => 'int',
		'sub_product_category' => 'int',
		'slider'               => 'int',
		'order'                => 'int',
		'attribute_set_id'     => 'int',

		// prices should be numeric, but keeping int as per your current DB
		'mrp'                  => 'int',
		'sales_price'          => 'int',
	];

	protected $fillable = [
		'title',
		'slug',
		'keywords',
		'short_description',
		'description',
		'sku',

		// keep fillable for backward-compatibility,
		// but controller/repository should not trust request input for 'type'
		'type',
		'product_code',
		'model',
		'is_featured',
		'video',
		'catalog',
		'thumb',
		'sort_order',
		'status',
		'hits',
		'product_category',
		'sub_product_category',
		'attribute_set_id',
		'slider',
		'order',
		'mrp',
		'sales_price',
	];

	protected static function boot()
	{
		parent::boot();

		static::creating(function (self $model) {
			$model->sub_product_category = (int)($model->sub_product_category ?? 0);
			$model->order = (int)($model->order ?? 0);

			// Slug generate if empty
			if (empty($model->slug) && !empty($model->title)) {
				$model->slug = Str::slug($model->title);
			}

			// Ensure slug uniqueness on create
			$model->slug = $model->makeUniqueSlug($model->slug, null);
		});

		static::updating(function (self $model) {
			$model->sub_product_category = (int)($model->sub_product_category ?? 0);
			$model->order = (int)($model->order ?? 0);

			// Regenerate slug only if title changed OR slug empty
			if ($model->isDirty('title') || empty($model->slug)) {
				$model->slug = Str::slug($model->title);
			}

			// Ensure slug uniqueness on update
			$model->slug = $model->makeUniqueSlug($model->slug, $model->id);
		});
	}

	protected function serializeDate(\DateTimeInterface $date): string
	{
		return (string) $date->getTimestamp();
	}

	/**
	 * Ensure slug is unique in product table.
	 * Adds "-2", "-3" ... suffix when conflict exists.
	 */
	protected function makeUniqueSlug(?string $baseSlug, ?int $ignoreId = null): ?string
	{
		if (empty($baseSlug)) {
			return $baseSlug;
		}

		$slug = $baseSlug;
		$i = 2;

		while (
			self::query()
			->where('slug', $slug)
			->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
			->exists()
		) {
			$slug = $baseSlug . '-' . $i;
			$i++;
		}

		return $slug;
	}

	/* -----------------------------------------------------------------
     | Relationships
     | -----------------------------------------------------------------
     */

	public function category()
	{
		return $this->belongsTo(ProductCategory::class, 'product_category', 'id');
	}

	public function subCategory()
	{
		return $this->belongsTo(ProductCategory::class, 'sub_product_category', 'id');
	}

	public function attributeSet()
	{
		return $this->belongsTo(AttributeSet::class, 'attribute_set_id', 'id');
		// If your model name is different, change AttributeSet::class accordingly.
	}

	public function variants()
	{
		return $this->hasMany(ProductVariant::class, 'product_id', 'id')
			->orderBy('id', 'asc');
	}

	public function configurableAttributes()
	{
		return $this->hasMany(ProductConfigurableAttribute::class, 'product_id', 'id');
	}

	public function productAttributeValues()
	{
		return $this->hasMany(ProductAttributeValue::class, 'product_id', 'id');
	}

	public function images()
	{
		return $this->hasMany(ProductImage::class, 'product_id', 'id')
			->orderBy('sort_order', 'asc')
			->orderBy('id', 'asc');
	}

	/* -----------------------------------------------------------------
     | Scopes
     | -----------------------------------------------------------------
     */

	public function scopePublished($query)
	{
		return $query->where('status', 1);
	}

	/* -----------------------------------------------------------------
     | Image Accessors (Helper-based, never breaks UI)
     | -----------------------------------------------------------------
     */

	public function getThumbUrlAttribute(): string
	{
		return ImageUploader::getFilePath($this->thumb ?? null, $this->created_at, 'thumbnail');
	}

	public function getThumbOriginalUrlAttribute(): string
	{
		return ImageUploader::getFilePath($this->thumb ?? null, $this->created_at);
	}
}
