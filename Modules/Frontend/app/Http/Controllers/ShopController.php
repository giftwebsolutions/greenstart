<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Frontend\Support\SeoData;
use Modules\Frontend\Interfaces\ProductInterface;
use Modules\SysAdmin\Interfaces\ProductCategoryInterface;
use Modules\SysAdmin\Models\Page;

class ShopController extends Controller
{
    public function __construct(
        protected ProductInterface $products,
        protected ProductCategoryInterface $categories
    ) {}

    /**
     * Main shop page — all products with full sidebar filters.
     */
    public function index(Request $request)
    {
        $filters        = $this->buildFilters($request);
        //dd($filters);
        $products       = $this->products->paginateForFrontend($filters, 12);
        $filterGroups   = $this->products->getFilterableGroups();
        $rootCategories = $this->categories->getMenuTree();

        $home = Page::where('slug', 'shop')->active()->first();

        $seoPayload = $home ? SeoData::page($home) : SeoData::basic('Home');

        return view('frontend::catalog.shop', array_merge(
            compact('products', 'filterGroups', 'rootCategories', 'filters'),
            ['activeTitle' => 'All Products'],
            $seoPayload
        ));
    }

    /**
     * Products filtered by category slug with sidebar.
     */
    public function category(string $slug, Request $request)
    {
        $category = $this->categories->findBySlug($slug);
        abort_if(!$category, 404);

        // Force the main category; user may further filter by sub-category
        $filters = $this->buildFilters($request, ['c_cat' => $category->id]);
        //dd($filters);
        if (isset($_GET['s_cat'])) {
            $filters = $this->buildFilters($request, ['s_cat' => $_GET['s_cat']]);
        }

        //dd($filters);

        $products       = $this->products->paginateForFrontend($filters, 12);
        $filterGroups   = $this->products->getFilterableGroups();
        $rootCategories = $this->categories->getMenuTree();
        $subCategories  = $category->children()->where('status', '1')->orderBy('sort')->get();

        return view('frontend::catalog.shop', array_merge(
            compact('products', 'filterGroups', 'rootCategories', 'category', 'subCategories', 'filters'),
            ['activeTitle' => $category->name],
            SeoData::productList($category->name)
        ));
    }

    /**
     * New arrivals — latest products, same sidebar.
     */
    public function newArrivals(Request $request)
    {
        $filters        = $this->buildFilters($request);
        $products       = $this->products->paginateForFrontend($filters, 12);
        $filterGroups   = $this->products->getFilterableGroups();
        $rootCategories = $this->categories->getMenuTree();

        return view('frontend::catalog.shop', array_merge(
            compact('products', 'filterGroups', 'rootCategories', 'filters'),
            ['activeTitle' => 'New Arrivals'],
            SeoData::productList('New Arrivals')
        ));
    }

    /**
     * Full-text search across title / keywords / SKU.
     */
    public function search(Request $request)
    {
        $q       = trim((string) $request->get('q', ''));
        $filters = $this->buildFilters($request, ['search' => $q]);

        $products       = $this->products->paginateForFrontend($filters, 12);
        $filterGroups   = $this->products->getFilterableGroups();
        $rootCategories = $this->categories->getMenuTree();
        $activeTitle    = $q !== '' ? "Search: {$q}" : 'Search Results';

        return view('frontend::catalog.shop', array_merge(
            compact('products', 'filterGroups', 'rootCategories', 'activeTitle', 'filters', 'q'),
            SeoData::productList($activeTitle, ['robots' => 'noindex,follow'])
        ));
    }

    // ----------------------------------------------------------------
    // Helpers
    // ----------------------------------------------------------------

    /**
     * Normalise all filter inputs from the request into a clean array.
     * $overrides lets calling methods hard-set values (e.g. c_cat from slug).
     */
    private function buildFilters(Request $request, array $overrides = []): array
    {
        $attrs = $request->input('attr', []);
        // Ensure it's always an array of arrays
        if (!is_array($attrs)) {
            $attrs = [];
        }

        return array_merge([
            'price_min' => $request->integer('price_min', 0),
            'price_max' => $request->integer('price_max', 100000),
            'c_cat'  => $request->integer('c_cat') ?: null,
            's_cat'  => $request->integer('s_cat') ?: null,
            'search' => $request->get('q'),
            'attrs'  => $attrs,
            'sort'   => $request->get('sort', 'newest'),
        ], $overrides);
    }
}
