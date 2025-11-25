<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeValue
 *
 * @property int $id
 * @property int $attribute_id
 * @property string $value
 * @property int $sort_order
 *
 * @property Attribute $attribute
 * @package Modules\SysAdmin\Models
 */
class AttributeValue extends Model
{
    protected $table = 'attribute_values';

    protected $casts = [
        'attribute_id' => 'int',
        'sort_order'   => 'int',
    ];

    protected $fillable = [
        'attribute_id',
        'value',
        'sort_order',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function variantValues()
    {
        return $this->hasMany(ProductVariantValue::class, 'attribute_value_id');
    }
}
