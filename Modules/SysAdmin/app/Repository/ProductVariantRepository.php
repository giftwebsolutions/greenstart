<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\ProductVariant;
use Modules\SysAdmin\Interfaces\ProductVariantInterface;

class ProductVariantRepository extends BaseRepository implements ProductVariantInterface
{
    protected $fillable = [];

    public function model()
    {
        return ProductVariant::class;
    }

    public function saveOrUpdate(array $data, ?int $id = null)
    {
        if ($id) {
            $variant = ProductVariant::findOrFail($id);
            $variant->update($data);
            return $variant;
        }

        return ProductVariant::create($data);
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getByProductId(int $productId)
    {
        return $this->model->where('product_id', $productId)->get();
    }
}
