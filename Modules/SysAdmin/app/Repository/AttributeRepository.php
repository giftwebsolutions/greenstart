<?php


namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Models\Attribute;
use Modules\SysAdmin\Interfaces\AttributeInterface;

class AttributeRepository extends BaseRepository implements AttributeInterface
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
        return Attribute::class;
    }

    public function getStatus()
    {
        return $this->getModel()->statuses;
    }
    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getAttributeSets()
    {
        return app(AttributeGroupRepository::class)->all()->pluck('name', 'id')->toArray();
    }

    public function getAttributeTypes()
    {
        return app(AttributeTypeRepository::class)->all()->pluck('name', 'code')->toArray();
    }
}
