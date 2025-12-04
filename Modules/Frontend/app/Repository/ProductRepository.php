<?php

namespace Modules\Frontend\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\Frontend\Interfaces\ProductInterface;
use Modules\SysAdmin\Models\Product;

class ProductRepository extends BaseRepository implements ProductInterface
{
    public function model()
    {
        return Product::class;
    }

    /**
     * Common listing for: all products / by category / search.
     */
    public function paginateForFrontend(array $filters = [], int $perPage = 12)
    {
        $this->resetModel();

        $this->scopeQuery(function ($q) use ($filters) {
            $q = $q->where('status', 1);

            // category filter
            if (!empty($filters['category_id'])) {
                $q->where('product_category', $filters['category_id']);
            }

            // search filter
            if (!empty($filters['search'])) {
                $search = $filters['search'];
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('keywords', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            }

            return $q->orderByDesc('created_at');
        });

        return $this->paginate($perPage);
    }

    public function findForFrontend(string|int $id): ?Product
    {
        $this->resetModel();

        $this->scopeQuery(function ($q) use ($id) {
            $q = $q->where('status', 1);

            if (is_numeric($id)) {
                return $q->where('id', (int) $id);
            }

            return $q->where('slug', $id);
        });

        return $this->first();
    }

    public function findWithVariantsForFrontend(string|int $id): ?Product
    {
        $this->resetModel();

        $this->with([
            'variants' => function ($q) {
                $q->where('status', 1)->orderBy('id');
            },
            'variants.values.attribute',
            'variants.values.attributeValue',
            'configurableAttributes.attribute.values',
        ]);

        $this->scopeQuery(function ($q) use ($id) {
            $q = $q->where('status', 1);

            if (is_numeric($id)) {
                return $q->where('id', (int) $id);
            }

            return $q->where('slug', $id);
        });

        return $this->first();
    }

    public function getRelatedForFrontend(Product $product, int $limit = 10)
    {
        $this->resetModel();

        $this->scopeQuery(function ($q) use ($product, $limit) {
            $q->where('status', 1)
                ->where('id', '!=', $product->id);

            if ($product->product_category) {
                $q->where('product_category', $product->product_category);
            }

            return $q->orderByDesc('created_at')->limit($limit);
        });

        return $this->get();
    }
}
