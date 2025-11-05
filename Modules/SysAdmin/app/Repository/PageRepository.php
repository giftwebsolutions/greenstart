<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\Page;
use App\Validators\PageValidator;
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
        $parents = $this->getModel()->select(['id', 'name'])->where('parent_id', NULL)->get()->toArray();
        return $parents;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $page = '';
        $data['author_id'] = auth()->user()->id;
        $data['parent_id'] = ($data['parent_id'] == 0) ? NULL : $data['parent_id'];

        if (isset($data['featured_image'])) {
            $data['featured_image'] = ImageUploader::upload($data['featured_image'], $this->getModel()->created_at);
        }

        if (isset($data['banner'])) {
            $data['banner'] = ImageUploader::upload($data['banner'], $this->getModel()->created_at);
        }

        //dd($data);
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
}
