<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Interfaces\EnquiryInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\Enquiry;

/**
 * Class EnquiryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EnquiryRepository extends BaseRepository implements EnquiryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Enquiry::class;
    }

    public function getStatus()
    {
        return $this->getModel()->statuses;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $query = [];
        if ($id !== 0) {
            $query =  parent::update($data, $id);
        } else {
            $query = parent::create($data);
        }
        return $query;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
