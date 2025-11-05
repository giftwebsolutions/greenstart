<?php

namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\GalleryInterface;
use Modules\SysAdmin\Models\Gallery;

/**
 * Class BlockRepositoryEloquent.
 *
 * @package namespace Modules\SysAdmin\Repository;
 */
class GalleryRepository extends BaseRepository implements GalleryInterface
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
        return Gallery::class;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $response = [];
        if ($id !== 0) {
            $model = $this->findOrFail($id);
            if (isset($data['thumbnail'])) {
                $data['thumbnail'] = ImageUploader::upload($data['thumbnail'], $model->created_at);
            }
            $response =  parent::update($data, $id);
        } else {
            if (isset($data['thumbnail'])) {
                $data['thumbnail'] = ImageUploader::upload($data['thumbnail'], $this->getModel()->created_at);
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
