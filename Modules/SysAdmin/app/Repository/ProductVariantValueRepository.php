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
            $value = $this->model->newQuery()->findOrFail($id);
            $value->fill($data);
            $value->save();

            return $value;
        }

        return $this->model->newQuery()->create($data);
    }

    public function getByVariantId(int $variantId)
    {
        return $this->model
            ->where('variant_id', $variantId)
            ->get();
    }


    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
