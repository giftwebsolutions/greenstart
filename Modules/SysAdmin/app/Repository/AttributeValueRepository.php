<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\AttributeValue;
use Modules\SysAdmin\Interfaces\AttributeValueInterface;

class AttributeValueRepository extends BaseRepository implements AttributeValueInterface
{
    protected $fillable = [];

    public function model()
    {
        return AttributeValue::class;
    }

    public function saveOrUpdate(array $data, ?int $id = null)
    {
        if ($id) {
            $value = AttributeValue::findOrFail($id);
            $value->update($data);
            return $value;
        }

        return AttributeValue::create($data);
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
