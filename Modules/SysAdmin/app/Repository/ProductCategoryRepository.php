<?php

namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Interfaces\ProductCategoryInterface;
use Modules\SysAdmin\Models\ProductCategory;

class ProductCategoryRepository extends BaseRepository implements ProductCategoryInterface
{
    /**
     * Specify Model class name.
     */
    public function model(): string
    {
        return ProductCategory::class;
    }

    /**
     * Create or update a product category.
     */
    public function saveOrUpdate(array $data, ?int $id = null)
    {
        if ($id) {
            $category = ProductCategory::findOrFail($id);
            $category->update($data);
            return $category;
        }

        return ProductCategory::create($data);
    }

    /**
     * Get Product Category Status List.
     */
    public function getStatuses(): array
    {
        return ProductCategory::$statuses;
    }

    /**
     * Get parent categories for dropdowns.
     */
    public function getCategories(): array
    {
        return ProductCategory::where('parent_id', 0)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Get subcategories for dropdowns.
     */
    public function getSubCategories(int $parentId = null): array
    {
        $query = ProductCategory::query()->orderBy('name');

        if ($parentId) {
            $query->where('parent_id', $parentId);
        }

        return $query->pluck('name', 'id')->toArray();
    }

    /**
     * Boot repository and apply request criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
