<?php

namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\SliderItemInterface;
use Modules\SysAdmin\Models\SliderItem;

/**
 * Class BlockRepositoryEloquent.
 *
 * @package namespace Modules\SysAdmin\Repository;
 */
class SliderItemRepository extends BaseRepository implements SliderItemInterface
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
        return SliderItem::class;
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
