<?php

namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Models\AttributeType;
use Modules\SysAdmin\Interfaces\AttributeTypeInterface;

class AttributeTypeRepository extends BaseRepository implements AttributeTypeInterface
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
        return AttributeType::class;
    }

    public function saveOrUpdate(array $data, ?int $id = null)
    {
        if ($id) {
            $group = AttributeType::findOrFail($id);
            $group->update($data);
            return $group;
        }

        return AttributeType::create($data);
    }

    public function getStatuses(): array
    {
        return (new AttributeType())->statuses;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}