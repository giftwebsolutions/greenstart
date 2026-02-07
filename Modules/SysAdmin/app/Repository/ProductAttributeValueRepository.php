<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Interfaces\ProductAttributeValueInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\ProductAttributeValue;

class ProductAttributeValueRepository extends BaseRepository implements ProductAttributeValueInterface
{
    public function model()
    {
        return ProductAttributeValue::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getByProductId(int $productId)
    {
        return $this->model->newQuery()
            ->where('product_id', $productId)
            ->get();
    }
}
