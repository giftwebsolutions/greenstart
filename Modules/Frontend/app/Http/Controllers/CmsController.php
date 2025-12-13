<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SysAdmin\Interfaces\PageInterface;

class CmsController extends Controller
{


    public function __construct(
        protected PageInterface $pageRepo
    ) {}

    /**
     * CMS Page View
     * /page/{slug}
     */
    public function show(string $slug)
    {
        $page = $this->pageRepo->findFrontendBySlug($slug, ['parent']);

        if (!$page) {
            return response()
                ->view('errors.404', [], 404);
        }

        return view('frontend::pages.view', compact('page'));
    }
}
