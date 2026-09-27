<?php

namespace Modules\SysAdmin\Repository;

use Illuminate\Support\Carbon;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Core\Eloquent\RequestCriteria;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\BlogInterface;
use Modules\SysAdmin\Models\Blog;

/**
 * Class BlogRepositoryEloquent.
 */
class BlogRepository extends BaseRepository implements BlogInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Blog::class;
    }

    public function getStatus()
    {
        return $this->getModel()->statuses;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $blog = $id !== 0 ? $this->find($id) : null;
        $oldImage = null;

        if (! empty($data['featured_image'])) {
            $data['featured_image'] = ImageUploader::upload($data['featured_image'], $blog?->created_at);
            $oldImage = $blog?->featured_image;
        } elseif ($blog?->featured_image && ! empty($data['remove_featured_image'])) {
            $data['featured_image'] = null;
            $oldImage = $blog->featured_image;
        }

        unset($data['remove_featured_image']);

        $savedBlog = $id !== 0
            ? parent::update($data, $id)
            : parent::create($data);

        if ($oldImage) {
            ImageUploader::remove((string) $savedBlog->created_at, $oldImage);
        }

        return $savedBlog;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /* =========================================================
     | Frontend Query Helpers
     ========================================================= */

    public function frontendBaseQuery(array $with = ['category'])
    {
        return $this->getModel()
            ->newQuery()
            ->with($with)
            ->where('status', 1)
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', Carbon::now());
            });
    }

    public function paginateFrontend(int $perPage = 12, array $with = ['category'])
    {
        return $this->frontendBaseQuery($with)
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findFrontendBySlug(string $slug, array $with = ['category'])
    {
        return $this->frontendBaseQuery($with)
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function relatedFrontend(int $blogId, ?int $categoryId, int $limit = 6, array $with = ['category'])
    {
        return $this->frontendBaseQuery($with)
            ->where('id', '!=', $blogId)
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    public function recentFrontend(int $limit = 4, ?int $excludeId = null, array $with = ['category'])
    {
        return $this->frontendBaseQuery($with)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    public function searchFrontendPaginate(string $term, int $perPage = 12, array $with = ['category'])
    {
        $query = $this->frontendBaseQuery($with);

        // safer than relying on your scopeSearch() (since it's declared static in your model)
        if ($term !== '') {
            $query->where(function ($qq) use ($term) {
                $qq->where('title', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%")
                    ->orWhere('content', 'like', "%{$term}%");
            });
        }

        return $query->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }
}
