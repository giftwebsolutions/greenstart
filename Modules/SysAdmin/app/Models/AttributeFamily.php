<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeFamily extends Model
{
    protected $table = 'attribute_families';

    protected $fillable = [
        'code',
        'name',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'integer',
        ];
    }

    public function groups()
    {
        return $this->hasMany(AttributeGroup::class, 'family_id')->orderBy('position')->orderBy('id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'attribute_family_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
