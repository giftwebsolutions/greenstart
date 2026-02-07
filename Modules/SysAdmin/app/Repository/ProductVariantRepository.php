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
            $variant = $this->model->newQuery()->findOrFail($id);
            $variant->fill($data);
            $variant->save();

            return $variant;
        }

        return $this->model->newQuery()->create($data);
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

    /**
     * Fetch a single variant by its primary key (id).
     */
    public function findById(int $id): ProductVariant
    {
        return $this->model->newQuery()->findOrFail($id);
    }
}
