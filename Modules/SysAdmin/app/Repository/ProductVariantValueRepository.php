<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\ProductVariantValue;
use Modules\SysAdmin\Interfaces\ProductVariantValueInterface;

class ProductVariantValueRepository extends BaseRepository implements ProductVariantValueInterface
{
    protected $fillable = [];

    public function model()
    {
        return ProductVariantValue::class;
    }

    public function saveOrUpdate(array $data, ?int $id = null)
    {
        if ($id) {
            $value = ProductVariantValue::findOrFail($id);
            $value->update($data);
            return $value;
        }

        return ProductVariantValue::create($data);
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getByVariantId(int $variantId)
    {
        return $this->model->where('product_id', $variantId)->get();
    }
}
