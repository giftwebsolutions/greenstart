<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\SysAdmin\Repository\TestimonialRepository;

class FrontendController extends Controller
{
    protected TestimonialRepository $testimonialRepo;

    public function __construct(TestimonialRepository $testimonialRepo)
    {
        $this->testimonialRepo = $testimonialRepo;
    }

    /**
     * Home Page
     */
    public function index()
    {
        $testimonials = $this->testimonialRepo->recentFrontend(6);

        return view('frontend::index', compact('testimonials'));
    }

    public function newarraival()
    {
        return view('frontend::pages.newarraival');
    }

    public function about()
    {
        // Testimonials can also be reused here if needed
        $testimonials = $this->testimonialRepo->recentFrontend(6);

        return view('frontend::pages.about', compact('testimonials'));
    }

    public function enquiry()
    {
        return view('frontend::pages.enquiry');
    }

    public function faqs()
    {
        return view('frontend::pages.faqs');
    }

    public function contact()
    {
        return view('frontend::pages.contact');
    }
}
