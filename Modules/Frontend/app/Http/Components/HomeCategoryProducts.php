<?php

namespace Modules\Frontend\Http\Components;

use Illuminate\View\Component;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Models\ProductCategory;

class HomeCategoryProducts extends Component
{
    public $products;
    public $categories;
    public string $title;
    public ?string $subtitle;
    public array $categoryIds;
    public int $limit;

    public function __construct(
        array|string|int $categoryIds = [],
        string $title = 'Recommended Products',
        ?string $subtitle = null,
        int $limit = 8
    ) {
        $this->categoryIds = collect((array) $categoryIds)
            ->flatMap(fn ($value) => is_string($value) ? explode(',', $value) : [$value])
            ->map(fn ($value) => (int) trim((string) $value))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->limit = $limit;

        $this->categories = ProductCategory::query()
            ->whereIn('id', $this->categoryIds)
            ->where('status', 1)
            ->orderBy('sort')
            ->orderBy('name')
            ->get();

        $this->products = Product::query()
            ->with('category')
            ->where('status', 1)
            ->where(function ($query) {
                $query->whereIn('product_category', $this->categoryIds)
                    ->orWhereIn('sub_product_category', $this->categoryIds);
            })
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->limit($this->limit)
            ->get();
    }

    public function render()
    {
        return view('frontend::components.home-category-products');
    }
}
