<?php

namespace Modules\SysAdmin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Slider
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $status
 * @property string|null $thumbnail
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Slider extends Model
{
    protected $table = 'sliders';

    protected $casts = [
        'status' => 'int',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'thumbnail',
    ];

    public function sliderItems()
    {
        return $this->hasMany(SliderItem::class, 'slider_id')->orderBy('sort_order')->orderBy('id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (self $model) {
            // Slug generate if empty
            if (empty($model->slug) && ! empty($model->name)) {

                $model->slug = Str::slug($model->name);
            }
            // Ensure slug uniqueness on create

            $model->slug = $model->makeUniqueSlug($model->slug, null);
        });
    }

    protected function makeUniqueSlug(?string $baseSlug, ?int $ignoreId = null): ?string
    {
        if (empty($baseSlug)) {
            return $baseSlug;
        }

        $slug = $baseSlug;
        $i = 2;

        while (
            self::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()

        ) {
            $slug = $baseSlug.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
