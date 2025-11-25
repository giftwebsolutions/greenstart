<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductConfigurableAttribute
 *
 * @property int $id
 * @property int $product_id
 * @property int $attribute_id
 *
 * @property Product $product
 * @property Attribute $attribute
 * @package Modules\SysAdmin\Models
 */
class ProductConfigurableAttribute extends Model
{
    protected $table = 'product_configurable_attributes';

    protected $casts = [
        'product_id'   => 'int',
        'attribute_id' => 'int',
    ];

    protected $fillable = [
        'product_id',
        'attribute_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
