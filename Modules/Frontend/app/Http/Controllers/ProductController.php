<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Frontend\Interfaces\ProductInterface;

class ProductController extends Controller
{
    public function __construct(protected ProductInterface $products) {}

    /**
     * Product detail page with variants.
     */
    public function show(string $slug)
    {
        $product = $this->products->findWithVariantsForFrontend($slug);
        abort_if(!$product, 404);

        $related = $this->products->getRelatedForFrontend($product, 10);
        //dd($related);
        return view('frontend::catalog.product-show', compact('product', 'related'));
    }
}
