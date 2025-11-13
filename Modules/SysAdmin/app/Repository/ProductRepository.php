<?php

namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Interfaces\ProductInterface;
use Modules\SysAdmin\Models\Category;
use Modules\SysAdmin\Models\ProductCategory;

class ProductRepository extends BaseRepository implements ProductInterface
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
        return Product::class;
    }

    /**
     * Create or update a product
     */
    public function saveOrUpdate(array $data, ?int $id = null)
    {
        if ($id) {
            $product = Product::findOrFail($id);
            $product->update($data);
            return $product;
        }

        return Product::create($data);
    }

    /**
     * Get Product Status List from Model
     */
    public function getStatuses(): array
    {
        return Product::$statuses;
    }

    /**
     * Get Category list for dropdowns
     */
    public function getCategories(): array
    {
        return ProductCategory::where('parent_id', 0)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Get Sub-category list for dropdowns
     */
    public function getSubCategories(int $parentId = null): array
    {
        $query =  ProductCategory::query()->orderBy('name');

        if ($parentId) {
            $query->where('parent_id', $parentId);
        }

        return $query->pluck('name', 'id')->toArray();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
