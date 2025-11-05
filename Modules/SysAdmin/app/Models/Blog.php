<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class Blog
 * 
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int|null $category_id
 * @property int|null $sub_category
 * @property string|null $content
 * @property string|null $keywords
 * @property string|null $description
 * @property int|null $author_id
 * @property string|null $featured_image
 * @property Carbon|null $published_at
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $type
 * @property BlogCategory|null $blog_category
 *
 * @package Modules\SysAdmin\Models
 */
class Blog extends Model implements Transformable
{
    use HasFactory, TransformableTrait;

    protected $table = 'blogs';

    const BLOG_TYPES = [
        1 => 'Article',
        2 => 'News',
        3 => 'Video',
        4 => 'Gallery',
    ];

    public $statuses = [
        0 => 'Delete',
        1 => 'Published',
        2 => 'Draft',
    ];

    protected $casts = [
        'category_id' => 'int',
        'sub_category' => 'int',
        'author_id' => 'int',
        'published_at' => 'datetime',
        'status' => 'int',
        'post_type' => 'int',
        'type' => 'int',
    ];

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'content',
        'keywords',
        'description',
        'video_url',
        'author_id',
        'featured_image',
        'published_at',
        'status'
    ];

    protected function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    protected function setPublishedAtAttribute($value)
    {
        return Attribute::make(
            set: fn (int $value) => date('Y-m-d H:i:s', strtotime($value)),
            get: fn (int $value) => date('d/m/Y HH:mm', strtotime($value)),
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            set: fn (int $value) => $value ?? 1,
            //get: fn (int $value) => $this->statuses[$value]
        );
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function postCount()
    {
        return $this->category->blogs()->count();
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', 1);
    }

    public function scopeOrderBy(Builder $query)
    {
        $query->orderBy("id", "DESC");
    }

    public function scopeByCategory(Builder $query, $category_id)
    {
        return $query->where('parent_id', $category_id)->active();
    }
    public static function scopeSearch(Builder $query, $searchTerm)
    {
        return $query->where('title', 'like', "%{$searchTerm}%")
            ->orWhere('description', 'like', "%{$searchTerm}%")
            ->orWhere('content', 'like', "%{$searchTerm}%");
    }
}
