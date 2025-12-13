<?php

namespace Modules\Frontend\Http\Components;

use Illuminate\View\Component;
use Modules\SysAdmin\Interfaces\ProductInterface;

class NewArrivals extends Component
{
    /**
     * Product collection.
     */
    public $products;

    /**
     * Number of products to fetch.
     */
    public $limit;

    /**
     * Constructor
     */
    public function __construct(ProductInterface $productRepository, $limit = 12)
    {
        $this->limit = $limit;

        // Fetch new arrival products via L5 repository
        $this->products = $productRepository
            ->scopeQuery(function ($q) use ($limit) {
                return $q->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->take($limit);
            })
            ->all();
    }

    /**
     * Render component view.
     */
    public function render()
    {
        return view('frontend::components.new-arrivals');
    }
}
