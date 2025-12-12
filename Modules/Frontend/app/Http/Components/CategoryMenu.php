<?php

namespace Modules\Frontend\App\Http\Components;

use Illuminate\View\Component;
use Modules\SysAdmin\Interfaces\ProductCategoryInterface;

class CategoryMenu extends Component
{
    public function __construct(
        protected ProductCategoryInterface $categories
    ) {}

    public function render()
    {
        return view('frontend::components.category-menu', [
            'verticalCategories' => $this->categories->getMenuTree(),
        ]);
    }
}
