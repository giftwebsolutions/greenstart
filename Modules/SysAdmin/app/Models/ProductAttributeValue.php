<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    protected $table = 'product_attribute_values';

    protected $fillable = [
        'product_id',
        'attribute_id',
        'attribute_value_id',
        'value',
        'created_at',
        'updated_at',
    ];
}
