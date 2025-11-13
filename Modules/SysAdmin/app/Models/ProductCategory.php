<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductCategory
 * 
 * @property int $id
 * @property int $parent_id
 * @property string|null $name
 * @property string $description
 * @property string|null $banner
 * @property string $slug
 * @property string|null $image
 * @property int $sort
 * @property string $status
 *
 * @package App\Models
 */
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
		'sort' => 'int'
	];

	protected $fillable = [
		'parent_id',
		'name',
		'description',
		'banner',
		'slug',
		'image',
		'sort',
		'status'
	];
}
