<?php

namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Interfaces\ProductCategoryInterface;
use Modules\SysAdmin\Models\ProductCategory;
use Modules\SysAdmin\Helpers\ImageUploader;

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

        $data['parent_id'] = ($data['parent_id'] == 0) ? NULL : $data['parent_id'];

        if ($id) {
            $category = ProductCategory::findOrFail($id);

            if (isset($data['banner'])) {
                $data['banner'] = ImageUploader::upload($data['banner'], $category->created_at);
            }
            if (isset($data['image'])) {
                $data['image'] = ImageUploader::upload($data['image'], $category->created_at);
            }

            $category->update($data);
            return $category;
        } else {
            if (isset($data['banner'])) {
                $data['banner'] = ImageUploader::upload($data['banner'], $this->getModel()->created_at);
            }
            if (isset($data['image'])) {
                $data['image'] = ImageUploader::upload($data['image'], $this->getModel()->created_at);
            }
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
    public function getParentCategories(): array
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
