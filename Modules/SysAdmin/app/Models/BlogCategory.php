<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

/**
 * Class BlogCategory
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property string|null $content
 * @property string|null $keywords
 * @property string|null $description
 * @property int $status
 * @property string|null $featured_image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property BlogCategory|null $blog_category
 * @property Collection|BlogCategory[] $blog_categories
 * @property Collection|Blog[] $blogs
 *
 * @package Modules\SysAdmin\Models
 */

class BlogCategory extends Model  implements Transformable
{
    use HasFactory, TransformableTrait;

    public $statuses = [
        0 => 'Delete',
        1 => 'Published',
        2 => 'Draft',
    ];

    protected $table = 'blog_categories';

    protected $casts = [
        'parent_id' => 'int',
        'status' => 'int'
    ];

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'content',
        'keywords',
        'description',
        'status',
        'featured_image'
    ];

    protected function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    protected function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] =  $value ?? NULL;
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            set: fn (int $value) => $value ?? 1,
            get: fn (int $value) => $this->statuses[$value]
        );
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function parents()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    // Accessor for post count (optional)
    public function getBlogCountAttribute()
    {
        return $this->blogs()->count();
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', 1);
    }

    public function scopeByParent(Builder $query, $parent_id)
    {
        return $query->where('parent_id', $parent_id)->active();
    }
}
