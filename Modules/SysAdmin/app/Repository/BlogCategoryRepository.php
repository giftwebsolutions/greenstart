<?php

namespace Modules\SysAdmin\Repository;

use Illuminate\Support\Carbon;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\BlogCategoryInterface;
use Modules\SysAdmin\Models\BlogCategory;

/**
 * Class BlogCategoryRepository.
 */
class BlogCategoryRepository extends BaseRepository implements BlogCategoryInterface
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return BlogCategory::class;
    }

    public function getStatus()
    {
        return $this->getModel()->statuses;
    }

    public function getParents()
    {
        $data = $this->getModel()->select(['id', 'name'])->where('parent_id', 0)->active()->get()->toArray();

        return $data;
    }

    public function getChildren($category_id)
    {
        $data = $this->getModel()->select(['id', 'name'])->where('parent_id', $category_id)->active()->get()->toArray();

        return $data;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $category = $id !== 0 ? $this->find($id) : null;
        $oldImage = null;
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if (! empty($data['featured_image'])) {
            $data['featured_image'] = ImageUploader::upload($data['featured_image'], $category?->created_at);
            $oldImage = $category?->featured_image;
        } elseif ($category?->featured_image && ! empty($data['remove_featured_image'])) {
            $data['featured_image'] = null;
            $oldImage = $category->featured_image;
        }

        unset($data['remove_featured_image']);

        $savedCategory = $id !== 0
            ? parent::update($data, $id)
            : parent::create($data);

        if ($oldImage) {
            ImageUploader::remove((string) $savedCategory->created_at, $oldImage);
        }

        return $savedCategory;
    }

    public function frontendWithCount()
    {
        return $this->getModel()
            ->newQuery()
            ->withCount(['blogs' => function ($q) {
                $q->where('status', 1)
                    ->where(function ($qq) {
                        $qq->whereNull('published_at')
                            ->orWhere('published_at', '<=', Carbon::now());
                    });
            }])
            ->orderBy('name')
            ->get();
    }

    public function findBySlug(string $slug)
    {
        return $this->getModel()->newQuery()->where('slug', $slug)->firstOrFail();
    }
}
