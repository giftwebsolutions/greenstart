<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Routing\Controller;

class ErrorController extends Controller
{
    /**
     * Custom 404 page
     */
    public function notFound()
    {
        return response()
            ->view('Frontend::errors.404', [], 404);
    }
}
