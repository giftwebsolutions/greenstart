<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string $keywords
 * @property string $short_description
 * @property string $description
 * @property string|null $sku
 * @property int $type
 * @property int $is_featured
 * @property string|null $video
 * @property string|null $catalog
 * @property string|null $thumb
 * @property int|null $sort_order
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $hits
 * @property int $product_category
 * @property int $sub_product_category
 * @property int $slider
 * @property int $order
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'product';

	public static $statuses = [
		0 => 'Delete',
		1 => 'Published',
		2 => 'Draft',
	];

	protected $casts = [
		'type' => 'int',
		'is_featured' => 'int',
		'sort_order' => 'int',
		'status' => 'int',
		'hits' => 'int',
		'product_category' => 'int',
		'sub_product_category' => 'int',
		'slider' => 'int',
		'order' => 'int'
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
		'order'
	];

	// Main Category (Parent)
	public function category()
	{
		return $this->belongsTo(ProductCategory::class, 'product_category', 'id');
	}

	// Sub Category (Child)
	public function subCategory()
	{
		return $this->belongsTo(ProductCategory::class, 'sub_product_category', 'id');
	}
}
