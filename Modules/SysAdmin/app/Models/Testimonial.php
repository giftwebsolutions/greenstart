<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Builder;

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
class Testimonial extends Model implements Transformable
{
    use HasFactory, TransformableTrait;

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
}
