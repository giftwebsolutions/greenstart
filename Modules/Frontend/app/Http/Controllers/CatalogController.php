<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend::catalog.index');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('frontend::catalog.show');
    }
}
