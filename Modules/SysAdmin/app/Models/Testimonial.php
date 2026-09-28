<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Modules\SysAdmin\Helpers\ImageUploader;

/**
 * Class Testimonial
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string|null $image
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testimonials';

    protected $fillable = [
        'name',
        'content',
        'image',
    ];

    /**
     * Scope: Latest first
     */
    public function scopeLatestFirst(Builder $query)
    {
        return $query->orderBy('id', 'DESC');
    }

    /**
     * Scope: Search testimonials
     */
    public function scopeSearch(Builder $query, $searchTerm)
    {
        return $query->where('name', 'like', "%{$searchTerm}%")
                     ->orWhere('content', 'like', "%{$searchTerm}%");
    }

    public function getImageUrlAttribute(): string
    {
        return ImageUploader::getFilePath($this->image, $this->created_at, 'thumbnail');
    }
}
