<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Page
 * 
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property string|null $content
 * @property string|null $keywords
 * @property string|null $description
 * @property int|null $author_id
 * @property int $status
 * @property string|null $featured_image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Page|null $page
 * @property Collection|Page[] $pages
 *
 * @package Modules\SysAdmin\Models
 */

class Page extends Model implements Transformable
{
    use HasFactory, TransformableTrait;

    protected $table = 'pages';

    public $statuses = [
        0 => 'Delete',
        1 => 'Published',
        2 => 'Draft',
    ];

    protected $casts = [
        'parent_id' => 'int',
        'author_id' => 'int',
        'status' => 'int'
    ];

    protected $fillable = [
        'title',
        'name',
        'slug',
        'parent_id',
        'content',
        'keywords',
        'description',
        'author_id',
        'status',
        'featured_image',
        'banner'
    ];

    protected function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    protected function setAuthorIdAttribute()
    {
        $this->attributes['author_id'] = auth()->user()->id;
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            set: fn (int $value) => $value ?? 1,
            //get: fn (int $value) => $this->statuses[$value]
        );
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', 1);
    }


    public function scopeOrder(Builder $query)
    {
        return $query->orderBy('order_id', 'asc');
    }

    protected function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] = $value ?? NULL;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function parents()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public static function getServiceMenuList(){
        $items = Page::select(['id','name', 'slug'])->where('parent_id', 4)->active()->get()->toArray();
        return $items;
    }
}
