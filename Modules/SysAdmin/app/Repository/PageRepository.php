<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\Page;
use Illuminate\Support\Carbon;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\PageInterface;

/**
 * Class PageRepositoryEloquent.
 *
 * @package namespace Modules\SysAdmin\App\Repository;
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
        $page = '';
        $createdAt = $this->getModel()->created_at;
        $data['author_id'] = auth()->user()->id;
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if ($id !== 0) {
            $_page = $this->find($id);
            $createdAt = $_page->created_at;
        }

        if (isset($data['featured_image'])) {
            $data['featured_image'] = ImageUploader::upload($data['featured_image'], $createdAt);
        }

        if (isset($data['banner'])) {
            $data['banner'] = ImageUploader::upload($data['banner'], $createdAt);
        }

        if ($id !== 0) {
            $page =  parent::update($data, $id);
        } else {
            $page = parent::create($data);
        }
        return $page;
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
