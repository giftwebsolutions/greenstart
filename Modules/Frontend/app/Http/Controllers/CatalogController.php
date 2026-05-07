<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Frontend\Support\SeoData;

class CatalogController extends Controller
{
    public function index()
    {
        return view('frontend::catalog.index', SeoData::productList('Catalog'));
    }

    public function show($id)
    {
        return view('frontend::catalog.show', SeoData::basic('Catalog'));
    }
}
