<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend::index');
    }

    public function about()
    {
        return view('frontend::pages.about');
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
