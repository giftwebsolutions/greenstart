<?php

namespace Modules\Frontend\Repository;

use Illuminate\Database\Eloquent\Collection;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\Frontend\Interfaces\ProductInterface;
use Modules\SysAdmin\Models\AttributeGroup;
use Modules\SysAdmin\Models\Product;

class ProductRepository extends BaseRepository implements ProductInterface
{
    public function model()
    {
        return Product::class;
    }

    /**
     * Amazon-style paginated listing.
     *
     * Supported $filters keys:
     *   c_cat   (int)   – product.product_category
     *   s_cat   (int)   – product.sub_product_category
     *   search  (string)– title / keywords / sku LIKE
     *   attrs   (array) – [attribute_id => [value_id, ...]] via product_attribute_values
     *   sort    (string)– newest | price_asc | price_desc | name_asc
     */
    public function paginateForFrontend(array $filters = [], int $perPage = 12)
    {
        $this->resetModel();

        $this->scopeQuery(function ($q) use ($filters) {
            $q->where('status', 1);

            if (!empty($filters['c_cat'])) {
                $q->where('product_category', (int) $filters['c_cat']);
            }

            if (!empty($filters['s_cat'])) {
                $q->where('sub_product_category', (int) $filters['s_cat']);
            }

            if (!empty($filters['search'])) {
                $search = $filters['search'];
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('keywords', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            }

            // Attribute filters: each selected attribute must match at least one chosen value
            if (!empty($filters['attrs']) && is_array($filters['attrs'])) {
                foreach ($filters['attrs'] as $attributeId => $valueIds) {
                    $valueIds = array_filter(array_map('intval', (array) $valueIds));
                    if (empty($valueIds)) {
                        continue;
                    }
                    $q->whereHas('productAttributeValues', function ($sub) use ($attributeId, $valueIds) {
                        $sub->where('attribute_id', (int) $attributeId)
                            ->whereIn('attribute_value_id', $valueIds);
                    });
                }
            }

            match ($filters['sort'] ?? 'newest') {
                'price_asc'  => $q->orderBy('sales_price', 'asc'),
                'price_desc' => $q->orderBy('sales_price', 'desc'),
                'name_asc'   => $q->orderBy('title', 'asc'),
                default      => $q->orderByDesc('created_at'),
            };

            return $q;
        });

        return $this->paginate($perPage);
    }

    public function findForFrontend(string|int $id): ?Product
    {
        $this->resetModel();

        $this->scopeQuery(function ($q) use ($id) {
            $q->where('status', 1);
            return is_numeric($id)
                ? $q->where('id', (int) $id)
                : $q->where('slug', $id);
        });

        return $this->first();
    }

    public function findWithVariantsForFrontend(string|int $id): ?Product
    {
        $this->resetModel();

        $this->with([
            'variants'                        => fn($q) => $q->where('status', 1)->orderBy('id'),
            'variants.values.attribute',
            'variants.values.attributeValue',
            'configurableAttributes.attribute.values',
            'images',
        ]);

        $this->scopeQuery(function ($q) use ($id) {
            $q->where('status', 1);
            return is_numeric($id)
                ? $q->where('id', (int) $id)
                : $q->where('slug', $id);
        });

        return $this->first();
    }

    public function getRelatedForFrontend(Product $product, int $limit = 10)
    {
        $this->resetModel();

        $this->scopeQuery(function ($q) use ($product, $limit) {
            $q->where('status', 1)->where('id', '!=', $product->id);

            if ($product->product_category) {
                $q->where('product_category', $product->product_category);
            }

            return $q->orderByDesc('created_at')->limit($limit);
        });

        return $this->get();
    }

    /**
     * Returns active attribute groups that have at least one filterable attribute with values.
     * Used to populate the sidebar filter panel.
     */
    public function getFilterableGroups(): Collection
    {
        return AttributeGroup::with(['attributes' => function ($q) {
            $q->where('filterable', 1)
              ->where('status', 1)
              ->orderBy('sort_order')
              ->with(['values' => fn($q) => $q->orderBy('sort_order')->orderBy('id')]);
        }])
        ->where('status', 1)
        ->orderBy('id')
        ->get()
        ->filter(fn($group) => $group->attributes->isNotEmpty())
        ->values();
    }
}
