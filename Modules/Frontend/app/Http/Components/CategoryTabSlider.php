<?php

namespace Modules\Frontend\Http\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Modules\SysAdmin\Interfaces\ProductInterface;
use Modules\SysAdmin\Interfaces\ProductCategoryInterface as CategoryInterface;

class CategoryTabSlider extends Component
{
    /** @var string */
    public $title;

    /** @var string */
    public $subTitle;

    /** @var string|null */
    public $banner;

    /** @var array */
    public $tabs; // prepared tabs with category + products

    /** @var int */
    public $limit;

    /**
     * @param  ProductInterface   $productRepository
     * @param  CategoryInterface  $categoryRepository
     * @param  string             $title
     * @param  string             $subTitle
     * @param  string|null        $banner
     * @param  array              $tabsConfig   [ ['category_id'=>1,'label'=>'Wheel Bearings'], ...]
     * @param  int                $limit        products per tab
     */
    public function __construct(
        ProductInterface $productRepository,
        CategoryInterface $categoryRepository,
        string $title = 'WHEELS',
        string $subTitle = '& TIRES',
        string $banner = null,
        array $tabsConfig = [],
        int $limit = 6
    ) {
        $this->title     = $title;
        $this->subTitle  = $subTitle;
        $this->banner    = $banner; // url or asset path
        $this->limit     = $limit;
        $this->tabs      = [];

        // Build tabs data: category + products
        $index = 1;

        foreach ($tabsConfig as $config) {
            if (empty($config['category_id'])) {
                continue;
            }

            $category = $categoryRepository->find($config['category_id']);

            if (! $category) {
                continue;
            }

            $label = $config['label'] ?? $category->name;

            $products = $productRepository
                ->scopeQuery(function ($q) use ($category, $limit) {
                    return $q->where('status', 1)
                        ->where('product_category', $category->id)
                        ->orderBy('created_at', 'desc')
                        ->take($limit);
                })
                ->all();

            // Ensure Collection for chunking in Blade
            if (! $products instanceof Collection) {
                $products = collect($products);
            }

            $this->tabs[] = [
                'id'       => 'tab-' . $index,
                'label'    => $label,
                'category' => $category,
                'products' => $products,
            ];

            $index++;
        }
    }

    public function render()
    {
        return view('frontend::components.category-tab-slider');
    }
}
