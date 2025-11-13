<?php

namespace Modules\SysAdmin\Models;

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

	public $statuses = [
		0 => 'Delete',
		1 => 'Published',
		2 => 'Draft',
	];

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

	public function groups()
	{
		return $this->belongsToMany(
			AttributeGroup::class,
			'attribute_mapping',
			'attribute_id',
			'group_id'
		)->withPivot(['value'])
			->withTimestamps();
	}

	public function mappings()
	{
		return $this->hasMany(AttributeMapping::class, 'attribute_id');
	}
}
