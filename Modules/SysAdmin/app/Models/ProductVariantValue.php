<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductVariantValue
 *
 * @property int $id
 * @property int $product_id
 * @property int $attribute_id
 * @property int $attribute_value_id
 *
 * @property ProductVariant $variant
 * @property Attribute $attribute
 * @property AttributeValue $attributeValue
 *
 * @package Modules\SysAdmin\Models
 */
class ProductVariantValue extends Model
{
    protected $table = 'product_variant_values';

    protected $casts = [
        'product_id' => 'int',
        'attribute_id'       => 'int',
        'attribute_value_id' => 'int',
    ];

    protected $fillable = [
        'product_id',
        'attribute_id',
        'attribute_value_id',
        'value'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
