<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\SysAdmin\Interfaces\EnquiryInterface;
use Modules\SysAdmin\Models\Page;
use Modules\SysAdmin\Models\ProductCategory;
use Modules\SysAdmin\Repository\SliderRepository;
use Modules\SysAdmin\Repository\SliderItemRepository;
use Modules\SysAdmin\Repository\TestimonialRepository;

class FrontendController extends Controller
{

    public function __construct() {}

    /**
     * Home Page
     */
    public function index(TestimonialRepository $testimonialRepo, SliderRepository $slider)
    {
        $tabs = $slider->with('sliderItems')->find('2')->toArray();
        //dd($tabs);
        $testimonials = $testimonialRepo->recentFrontend(6);
        $home = Page::where('slug', 'home')->active()->first();
        return view('frontend::index', compact('testimonials', 'home', 'tabs'));
    }

    public function newarraival()
    {
        return view('frontend::pages.newarraival');
    }

    public function about()
    {
        // Testimonials can also be reused here if needed
        $about = Page::where('slug', 'about')->active()->first();
        return view('frontend::pages.about', compact('about'));
    }

    public function enquiry()
    {
        $enquiry = Page::where('slug', 'enquiry')->active()->first();
        $productCategory = ProductCategory::select(['id', 'name', 'slug', 'parent_id'])
            ->where('parent_id', 0)->where('status', '1')->get()
            ->toArray();

        return view('frontend::pages.enquiry')->with(['enquiry' => $enquiry, 'category' => $productCategory]);
    }

    public function storeEnquiry(\Modules\SysAdmin\Requests\EnquiryFormRequest $request, EnquiryInterface $enquiry)
    {
        $data = $request->validated();

        // Ensure defaults if not present
        $data['category_id'] = $data['category_id'] ?? 0;
        $data['product_id']  = $data['product_id'] ?? 0;
        $data['status']      = $data['status'] ?? 1;

        $enquiry->saveOrUpdate($data);

        return response()->json([
            'status'  => true,
            'message' => 'Thanks! We received your enquiry. Our team will contact you soon.',
        ]);
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
