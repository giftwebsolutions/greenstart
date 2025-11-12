<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 * 
 * @property int $id
 * @property string $name
 * @property int $group_id
 * @property int|null $sort_order
 * @property int $type
 * @property bool $comparable
 * @property string $require
 * @property int $status
 * 
 * @property AttributeGroup $attribute_group
 * @property AttributeType $attribute_type
 *
 * @package App\Models
 */
class Attribute extends Model
{
	protected $table = 'attribute';
	public $timestamps = false;

	protected $casts = [
		'group_id' => 'int',
		'sort_order' => 'int',
		'type' => 'int',
		'comparable' => 'bool',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'group_id',
		'sort_order',
		'type',
		'comparable',
		'require',
		'status'
	];

	public function attribute_group()
	{
		return $this->belongsTo(AttributeGroup::class, 'group_id');
	}

	public function attribute_type()
	{
		return $this->belongsTo(AttributeType::class, 'type');
	}
}
