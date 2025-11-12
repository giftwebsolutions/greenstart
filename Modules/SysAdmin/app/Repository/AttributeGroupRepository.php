<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Interfaces\AttributeGroupInterface;
use Modules\SysAdmin\Models\AttributeGroup;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;

class AttributeGroupRepository extends BaseRepository implements AttributeGroupInterface
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
        return AttributeGroup::class;
    }

    public function getStatus()
    {
        return $this->getModel()->statuses;
    }


    public function saveOrUpdate(array $data, ?int $id = null)
    {
        if ($id) {
            $group = AttributeGroup::findOrFail($id);
            $group->update($data);
            return $group;
        }

        return AttributeGroup::create($data);
    }

    public function getStatuses(): array
    {
        return (new AttributeGroup())->statuses;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
