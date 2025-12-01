<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductVariant
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $name
 * @property string $sku
 * @property float $price
 * @property string|null $thumb
 * @property int $stock
 * @property int $status
 *
 * @property Product $product
 * @property ProductVariantValue[] $values
 *
 * @package Modules\SysAdmin\Models
 */
class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $casts = [
        'product_id' => 'int',
        'price'      => 'float',
        'stock'      => 'int',
        'status'     => 'int',
    ];

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price',
        'thumb',
        'stock',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function values()
    {
        return $this->hasMany(ProductVariantValue::class, 'product_id');
    }
}
