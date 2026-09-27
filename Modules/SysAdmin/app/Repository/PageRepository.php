<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Core\Eloquent\RequestCriteria;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\PageInterface;
use Modules\SysAdmin\Models\Page;

/**
 * Class PageRepositoryEloquent.
 */
class PageRepository extends BaseRepository implements PageInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Page::class;
    }

    public function getStatus()
    {
        return $this->getModel()->statuses;
    }

    public function getParents()
    {
        $parents = $this->getModel()->select(['id', 'name'])->where('parent_id', 0)->get()->toArray();

        return $parents;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $page = $id !== 0 ? $this->find($id) : null;
        $createdAt = $page?->created_at;
        $filesToRemove = [];
        $data['author_id'] = auth()->user()->id;
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if (! empty($data['featured_image'])) {
            $data['featured_image'] = ImageUploader::upload($data['featured_image'], $createdAt);
            if ($page?->featured_image) {
                $filesToRemove[] = $page->featured_image;
            }
        } elseif ($page?->featured_image && ! empty($data['remove_featured_image'])) {
            $data['featured_image'] = null;
            $filesToRemove[] = $page->featured_image;
        }

        if (! empty($data['banner'])) {
            $data['banner'] = ImageUploader::upload($data['banner'], $createdAt);
            if ($page?->banner) {
                $filesToRemove[] = $page->banner;
            }
        } elseif ($page?->banner && ! empty($data['remove_banner'])) {
            $data['banner'] = null;
            $filesToRemove[] = $page->banner;
        }

        unset($data['remove_featured_image'], $data['remove_banner']);

        $savedPage = $id !== 0
            ? parent::update($data, $id)
            : parent::create($data);

        foreach (array_unique($filesToRemove) as $filename) {
            ImageUploader::remove((string) $savedPage->created_at, $filename);
        }

        return $savedPage;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function frontendBaseQuery(array $with = ['parent'])
    {
        return $this->getModel()
            ->newQuery()
            ->with($with)
            ->where('status', 1);
    }

    public function findFrontendBySlug(string $slug, array $with = ['parent'])
    {
        return $this->frontendBaseQuery($with)
            ->where('slug', $slug)
            ->first();
    }

    public function getChildrenByParentId(int $parentId, array $columns = ['id', 'name', 'slug'])
    {
        return $this->frontendBaseQuery([])
            ->select($columns)
            ->where('parent_id', $parentId)
            ->orderBy('order_id', 'asc')
            ->get();
    }
}
