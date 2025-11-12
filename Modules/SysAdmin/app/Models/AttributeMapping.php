<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeMapping
 * 
 * @property int $id
 * @property int $attribute_id
 * @property int $product_id
 * @property string $value
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @package App\Models
 */
class AttributeMapping extends Model
{
	protected $table = 'attribute_mapping';

	protected $casts = [
		'attribute_id' => 'int',
		'product_id' => 'int'
	];

	protected $fillable = [
		'attribute_id',
		'product_id',
		'value'
	];
}
