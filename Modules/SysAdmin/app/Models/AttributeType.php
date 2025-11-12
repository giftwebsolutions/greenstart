<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeType
 * 
 * @property int $attribute_type_id
 * @property string $type_name
 * @property string|null $identifier
 * @property string $status
 * 
 * @property Collection|Attribute[] $attributes
 *
 * @package App\Models
 */
class AttributeType extends Model
{
	protected $table = 'attribute_type';
	protected $primaryKey = 'attribute_type_id';
	public $timestamps = false;

	protected $fillable = [
		'type_name',
		'identifier',
		'status'
	];

	public function attributes()
	{
		return $this->hasMany(Attribute::class, 'type');
	}
}
