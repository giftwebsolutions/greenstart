<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\SysAdmin\Helpers\ImageUploader;

/**
 * Class ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string $image
 * @property int|null $sort_order
 */
class ProductImage extends Model
{
	protected $table = 'product_image';

	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'sort_order' => 'int',
	];

	protected $fillable = [
		'product_id',
		'image',
		'sort_order',
	];

	/* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id', 'id');
	}

    /* -----------------------------------------------------------------
     |  Accessors / Helpers
     | -----------------------------------------------------------------
     */

	/**
	 * Get gallery image URL (thumbnail preferred).
	 * Always safe – falls back to default image.
	 */
	public function getImageUrlAttribute(): string
	{
		if (!$this->image || !$this->product || !$this->product->created_at) {
			return ImageUploader::getFilePath(null);
		}

		return ImageUploader::getFilePath(
			$this->image,
			$this->product->created_at,
			'thumbnail'
		);
	}

	/**
	 * Get full image URL (non-thumbnail).
	 */
	public function getOriginalImageUrlAttribute(): string
	{
		if (!$this->image || !$this->product || !$this->product->created_at) {
			return ImageUploader::getFilePath(null);
		}

		return ImageUploader::getFilePath(
			$this->image,
			$this->product->created_at
		);
	}
}
