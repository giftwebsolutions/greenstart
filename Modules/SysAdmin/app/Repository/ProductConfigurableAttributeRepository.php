<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\ProductConfigurableAttribute;
use Modules\SysAdmin\Interfaces\ProductConfigurableAttributeInterface;

class ProductConfigurableAttributeRepository extends BaseRepository implements ProductConfigurableAttributeInterface
{
    protected $fillable = [];

    public function model()
    {
        return ProductConfigurableAttribute::class;
    }

    public function saveOrUpdate(array $data, ?int $id = null)
    {
        if ($id) {
            $entry = ProductConfigurableAttribute::findOrFail($id);
            $entry->update($data);
            return $entry;
        }

        return ProductConfigurableAttribute::create($data);
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
