<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SysAdmin\Interfaces\ProductInterface;

class ProductController extends Controller
{
    public function __construct(
        protected ProductInterface $productRepository
    ) {}

    /**
     * Product list (with pagination from L5 repo).
     */
    public function index(Request $request)
    {
        $filters = [
            'category_id' => $request->get('category'),
            'search'      => $request->get('q'),
        ];

        $products = $productRepository = $this->productRepository
            ->paginateForFrontend($filters, 12);

        return view('frontend::product.index', compact('products'));
    }

    /**
     * Product detail page.
     */
    public function show(string $slug)
    {
        $product = $this->productRepository->findForFrontend($slug);

        abort_if(! $product, 404);

        $related = $this->productRepository->getRelatedForFrontend($product, 12);

        return view('frontend::product.show', compact('product', 'related'));
    }
}
