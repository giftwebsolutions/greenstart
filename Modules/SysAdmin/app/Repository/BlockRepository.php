<?php

namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Models\Blocks;
use Modules\SysAdmin\Interfaces\BlockInterface;
use Modules\SysAdmin\Helpers\ImageUploader;

/**
 * Class BlockRepositoryEloquent.
 *
 * @package namespace Modules\SysAdmin\Repository;
 */
class BlockRepository extends BaseRepository implements BlockInterface
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
        return Blocks::class;
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
