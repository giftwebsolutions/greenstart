<?php

namespace Modules\Frontend\Http\Components;

use Illuminate\View\Component;
use Modules\SysAdmin\Interfaces\ProductCategoryInterface;

class PopularCategories extends Component
{
    /** @var \Illuminate\Support\Collection */
    public $categories;

    /** @var string */
    public $title;

    public function __construct(
        ProductCategoryInterface $categoryRepository,
        ?string $title = 'Shop by Category',
        int $limit = 12
    ) {
        $this->title = $title;

        // First-level categories only (parent_id = 0)
        $this->categories = $categoryRepository
            ->scopeQuery(function ($q) {
                return $q->where('parent_id', 0)->orderBy('id');
            })
            ->all()
            ->take($limit);
    }

    public function render()
    {
        return view('frontend::components.popular-categories');
    }
}
