<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CmsController extends Controller
{


    public function show($slug)
    {
        return view('frontend::pages.view');
    }
}
