<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Frontend\Interfaces\ProductInterface;
use Modules\SysAdmin\Interfaces\ProductCategoryInterface;

class ProductController extends Controller
{
    public function __construct(
        protected ProductInterface $products,
        protected ProductCategoryInterface $categories
    ) {}

    /**
     * 1) Category list page
     */
    public function categories()
    {
        $rootCategories = $this->categories->getRootCategories();

        return view('frontend::catalog.categories', compact('rootCategories'));
    }

    /**
     * 2) Normal product list (all categories, paginated)
     */
    public function index(Request $request)
    {
        $filters = [
            'search'      => $request->get('q'),
            'category_id' => $request->get('category_id'),
        ];

        $products    = $this->products->paginateForFrontend($filters, 12);
        $activeTitle = 'All Products';

        return view('frontend::catalog.product-list', compact('products', 'activeTitle'));
    }

    /**
     * 3) Product list by category slug
     */
    public function category(string $slug, Request $request)
    {
        $category = $this->categories->findBySlug($slug);

        abort_if(! $category, 404);

        $filters = [
            'category_id' => $category->id,
            'search'      => $request->get('q'),
        ];

        $products    = $this->products->paginateForFrontend($filters, 12);
        $activeTitle = $category->name;

        return view('frontend::catalog.product-list', compact('products', 'activeTitle', 'category'));
    }

    /**
     * 4) Product search page
     */
    public function search(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $filters = [
            'search' => $q,
        ];

        $products    = $this->products->paginateForFrontend($filters, 12);
        $activeTitle = $q !== '' ? "Search: {$q}" : 'Search Results';

        return view('frontend::catalog.product-list', compact('products', 'activeTitle', 'q'));
    }

    /**
     * 5) Product detail page (with variants)
     */
    public function show(string $slug)
    {
        $product = $this->products->findWithVariantsForFrontend($slug);

        abort_if(! $product, 404);

        $related = $this->products->getRelatedForFrontend($product, 10);

        return view('frontend::catalog.product-show', compact('product', 'related'));
    }
}
