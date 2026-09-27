<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Frontend\Interfaces\ProductInterface;
use Modules\Frontend\Support\SeoData;
use Modules\SysAdmin\Interfaces\ProductCategoryInterface;
use Modules\SysAdmin\Models\Page;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Models\ProductCategory;

class ShopController extends Controller
{
    public function __construct(
        protected ProductInterface $products,
        protected ProductCategoryInterface $categories
    ) {}

    /**
     * Main shop page — category landing page.
     */
    public function index(Request $request)
    {
        $rootCategories = ProductCategory::with(['children' => function ($query) {
            $query->where('status', '1')->orderBy('sort')->orderBy('name');
        }])
            ->where(function ($query) {
                $query->where('parent_id', 0)->orWhereNull('parent_id');
            })
            ->where('status', '1')
            ->orderBy('sort')
            ->orderBy('name')
            ->get();

        $categoryIds = $rootCategories
            ->flatMap(fn ($category) => collect([$category->id])->merge($category->children->pluck('id')))
            ->unique()
            ->values();

        $mainCounts = Product::query()
            ->where('status', 1)
            ->whereIn('product_category', $categoryIds)
            ->selectRaw('product_category, count(*) as aggregate')
            ->groupBy('product_category')
            ->pluck('aggregate', 'product_category');

        $subCounts = Product::query()
            ->where('status', 1)
            ->whereIn('sub_product_category', $categoryIds)
            ->selectRaw('sub_product_category, count(*) as aggregate')
            ->groupBy('sub_product_category')
            ->pluck('aggregate', 'sub_product_category');

        $categoryProductCounts = [];
        $categoryImages = [];

        $imageProducts = Product::query()
            ->where('status', 1)
            ->whereNotNull('thumb')
            ->where(function ($query) use ($categoryIds) {
                $query->whereIn('product_category', $categoryIds)
                    ->orWhereIn('sub_product_category', $categoryIds);
            })
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->get(['id', 'product_category', 'sub_product_category', 'thumb', 'created_at']);

        foreach ($rootCategories as $category) {
            $categoryProductCounts[$category->id] = (int) ($mainCounts[$category->id] ?? 0);
            $categoryImages[$category->id] = $category->image;

            foreach ($category->children as $child) {
                $childCount = (int) ($mainCounts[$child->id] ?? 0) + (int) ($subCounts[$child->id] ?? 0);
                $categoryProductCounts[$child->id] = $childCount;
                $categoryProductCounts[$category->id] += $childCount;
                $categoryImages[$child->id] = $child->image;
            }
        }

        foreach ($imageProducts as $product) {
            if (empty($categoryImages[$product->product_category])) {
                $categoryImages[$product->product_category] = [
                    'file' => $product->thumb,
                    'created_at' => $product->created_at,
                ];
            }

            if (! empty($product->sub_product_category) && empty($categoryImages[$product->sub_product_category])) {
                $categoryImages[$product->sub_product_category] = [
                    'file' => $product->thumb,
                    'created_at' => $product->created_at,
                ];
            }
        }

        $home = Page::where('slug', 'shop')->active()->first();

        $seoPayload = $home ? SeoData::page($home) : SeoData::basic('Shop');

        return view('frontend::catalog.index', array_merge(
            compact('rootCategories', 'categoryProductCounts', 'categoryImages'),
            ['activeTitle' => 'Shop by Category'],
            $seoPayload
        ));
    }

    /**
     * Products filtered by category slug with sidebar.
     */
    public function category(string $slug, Request $request)
    {
        $category = $this->categories->findBySlug($slug);
        abort_if(! $category, 404);

        $filters = $this->buildFilters($request, ['c_cat' => $category->id]);
        if ($request->filled('s_cat')) {
            $filters = $this->buildFilters($request, ['s_cat' => $request->integer('s_cat')]);
        }

        $products = $this->products->paginateForFrontend($filters, $this->perPage($request));
        $filterGroups = $this->products->getFilterableGroups();
        $rootCategories = $this->categories->getMenuTree();
        $subCategories = $category->children()->where('status', '1')->orderBy('sort')->get();

        if ($request->ajax()) {
            return $this->ajaxListingResponse($products);
        }

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
        $filters = $this->buildFilters($request);
        $products = $this->products->paginateForFrontend($filters, $this->perPage($request));
        $filterGroups = $this->products->getFilterableGroups();
        $rootCategories = $this->categories->getMenuTree();

        if ($request->ajax()) {
            return $this->ajaxListingResponse($products);
        }

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
        $q = trim((string) $request->get('q', ''));
        $filters = $this->buildFilters($request, ['search' => $q]);

        $products = $this->products->paginateForFrontend($filters, $this->perPage($request));
        $filterGroups = $this->products->getFilterableGroups();
        $rootCategories = $this->categories->getMenuTree();
        $activeTitle = $q !== '' ? "Search: {$q}" : 'Search Results';

        if ($request->ajax()) {
            return $this->ajaxListingResponse($products);
        }

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
        if (! is_array($attrs)) {
            $attrs = [];
        }

        return array_merge([
            'price_min' => $request->integer('price_min', 0),
            'price_max' => $request->integer('price_max', 100000),
            'c_cat' => $request->integer('c_cat') ?: null,
            's_cat' => $request->integer('s_cat') ?: null,
            'search' => $request->get('q'),
            'attrs' => $attrs,
            'sort' => $request->get('sort', 'newest'),
        ], $overrides);
    }

    private function perPage(Request $request): int
    {
        $default = (int) config('site-settings.products_per_page', 12);

        return min(max($request->integer('per_page', $default), 6), 36);
    }

    private function ajaxListingResponse($products)
    {
        $shownTo = min($products->currentPage() * $products->perPage(), $products->total());

        return response()->json([
            'grid' => view('frontend::catalog.partials.product-grid', compact('products'))->render(),
            'pagination' => $products->withQueryString()->links('pagination::bootstrap-5')->render(),
            'count' => view('frontend::catalog.partials.product-count', compact('products'))->render(),
            'next_page_url' => $products->appends(request()->query())->nextPageUrl(),
            'total' => $products->total(),
            'shown_to' => $shownTo,
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
        ]);
    }
}
