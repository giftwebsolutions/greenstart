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
	public $timestamps = true;

	protected $casts = [
		'attribute_id' => 'int',
		'group_id' => 'int'
	];

	protected $fillable = [
		'attribute_id',
		'group_id',
		'value'
	];

	// Each mapping belongs to one attribute
	public function attribute()
	{
		return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
	}

	// Each mapping belongs to one group
	public function group()
	{
		return $this->belongsTo(AttributeGroup::class, 'group_id', 'id');
	}
}
