<?php

namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\SliderInterface;
use Modules\SysAdmin\Models\Slider;

/**
 * Class BlockRepositoryEloquent.
 *
 * @package namespace Modules\SysAdmin\Repository;
 */
class SliderRepository extends BaseRepository implements SliderInterface
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
    public function model()
    {
        return Slider::class;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $response = '';
        if (isset($data['thumbnail'])) {
            $data['thumbnail'] = ImageUploader::upload($data['thumbnail'], $this->getModel()->created_at);
        }
        if ($id !== 0) {
            $response =  parent::update($data, $id);
        } else {
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
