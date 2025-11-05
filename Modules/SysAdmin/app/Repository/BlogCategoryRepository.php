<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\BlogCategory;
use App\Validators\BlogCategoryValidator;
use Modules\SysAdmin\Interfaces\BlogCategoryInterface;
use Modules\SysAdmin\Helpers\ImageUploader;

/**
 * Class BlogCategoryRepository.
 *
 * @package namespace Modules\SysAdmin\Repository;
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
     *
     * @return string
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
        $data = $this->getModel()->select(['id', 'name'])->where('parent_id', NULL)->active()->get()->toArray();
        return $data;
    }

    public function getChildren($category_id)
    {
        $data = $this->getModel()->select(['id', 'name'])->where('parent_id', $category_id)->active()->get()->toArray();
        return $data;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $response = '';
        if (isset($data['featured_image'])) {
            $data['featured_image'] = ImageUploader::upload($data['featured_image'], $this->getModel()->created_at);
        }
        if ($id !== 0) {
            $response =  parent::update($data, $id);
        } else {
            $response = parent::create($data);
        }
        return $response;
    }
}
