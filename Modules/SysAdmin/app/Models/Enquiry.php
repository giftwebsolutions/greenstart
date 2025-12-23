<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\SysAdmin\Models\ProductCategory;
use Modules\SysAdmin\Models\Product;

class Enquiry extends Model
{
    // Change this if your table name is different
    protected $table = 'enquiries';

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Your table has created_at + updated_at columns
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public static array $statuses = [
        0 => 'Inactive',
        1 => 'New',
        2 => 'Follow up',
        2 => 'Confirmed',
        3 => 'Cancelled'
    ];

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'city',
        'state',
        'message',
        'category_id',
        'product_id',
        'qty',
        'price',
        'req_price',
        'status',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'product_id'  => 'integer',
        'status'      => 'integer',
        'qty'         => 'decimal:2',
        'price'       => 'decimal:2',
        'req_price'   => 'decimal:2',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function setCategoryIdAttribute($value): void
    {
        $this->attributes['category_id'] = !empty($value) ? (int) $value : 0;
    }

    public function setProductIdAttribute($value): void
    {
        $this->attributes['product_id'] = !empty($value) ? (int) $value : 0;
    }
    
    /* ---------------- Relationships (optional) ---------------- */

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /* ---------------- Scopes (optional) ---------------- */

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}