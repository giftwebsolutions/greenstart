<?php

namespace Modules\Frontend\Http\Components;

use Illuminate\View\Component;
use Modules\SysAdmin\Interfaces\TestimonialInterface;

class Testimonials extends Component
{

    /**
     * Number of products to fetch.
     */
    public $limit;

    public $testimonials;

    /**
     * Constructor
     */
    public function __construct(TestimonialInterface $testimonial, $limit = 6)
    {
        $this->limit = $limit;

        // Fetch new arrival products via L5 repository
        $this->testimonials  = $testimonial->recentFrontend($limit);
    }

    /**
     * Render component view.
     */
    public function render()
    {
        return view('frontend::components.testimonials');
    }
}
