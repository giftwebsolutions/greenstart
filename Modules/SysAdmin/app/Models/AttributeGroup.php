<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeGroup
 * 
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int $status
 * 
 * @property Collection|Attribute[] $attributes
 *
 * @package App\Models
 */
class AttributeGroup extends Model
{
	protected $table = 'attribute_group';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'status'
	];

	public function attributes()
	{
		return $this->hasMany(Attribute::class, 'group_id');
	}
}
