<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\Blog;
use App\Validators\BlogValidator;
use Modules\SysAdmin\Interfaces\BlogInterface;
use Modules\SysAdmin\Helpers\ImageUploader;

/**
 * Class BlogRepositoryEloquent.
 *
 * @package namespace Modules\SysAdmin\Repository;
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
        $response = '';
        
        if ($id !== 0) {
            $blog = $this->getModel()->find($id);
            if (isset($data['featured_image'])) {
                $data['featured_image'] = ImageUploader::upload($data['featured_image'], $blog->created_at);
            }
            $response =  parent::update($data, $id);
        } else {
            if (isset($data['featured_image'])) {
                $data['featured_image'] = ImageUploader::upload($data['featured_image'], $this->getModel()->created_at);
            }
            $response = parent::create($data);
        }
        return $response;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
