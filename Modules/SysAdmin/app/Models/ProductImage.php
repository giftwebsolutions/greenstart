<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductImage
 * 
 * @property int $id
 * @property int $product_id
 * @property string $image
 * @property int|null $sort_order
 *
 * @package App\Models
 */
class ProductImage extends Model
{
	protected $table = 'product_image';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'sort_order' => 'int'
	];

	protected $fillable = [
		'product_id',
		'image',
		'sort_order'
	];
}
