<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Frontend\Support\SeoData;
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
        $sliderdata = [];
        $slider = $slider->with('sliderItems')->findWhere(['slug' => 'home'])->first();

        if ($slider) {
            $slider = $slider->toArray();
            $sliderdata = $slider['slider_items'];
        }

        $testimonials = $testimonialRepo->recentFrontend(6);
        $home = Page::where('slug', 'home')->active()->first();

        $seoPayload = $home ? SeoData::page($home) : SeoData::basic('Home');

        return view('frontend::index', array_merge(
            compact('testimonials', 'home', 'sliderdata'),
            $seoPayload
        ));
    }

    public function about()
    {
        $about = Page::where('slug', 'about')->active()->first();

        $seoPayload = $about ? SeoData::page($about) : SeoData::basic('About Us');

        return view('frontend::pages.about', array_merge(compact('about'), $seoPayload));
    }

    public function enquiry()
    {
        $enquiry = Page::where('slug', 'enquiry')->active()->first();
        $productCategory = ProductCategory::select(['id', 'name', 'slug', 'parent_id'])
            ->where('parent_id', 0)->where('status', '1')->get()
            ->toArray();

        $seoPayload = $enquiry ? SeoData::page($enquiry) : SeoData::basic('Enquiry');

        return view('frontend::pages.enquiry', array_merge(
            ['enquiry' => $enquiry, 'category' => $productCategory],
            $seoPayload
        ));
    }

    public function storeEnquiry(\Modules\SysAdmin\Requests\EnquiryFormRequest $request, EnquiryInterface $enquiry)
    {
        //dd($request);
        $data = $request->validated();
        //dd($data);
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
        $faqs = Page::where('slug', 'faqs')->active()->first();

        $seoPayload = $faqs ? SeoData::page($faqs) : SeoData::basic('FAQs');

        return view('frontend::pages.faqs', array_merge(compact('faqs'), $seoPayload));
    }

    public function contact()
    {
        $contact = Page::where('slug', 'contact')->active()->first();

        $seoPayload = $contact ? SeoData::page($contact) : SeoData::basic('Contact Us');

        return view('frontend::pages.contact', array_merge(compact('contact'), $seoPayload));
    }
}
