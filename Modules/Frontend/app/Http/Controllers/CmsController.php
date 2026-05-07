<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Frontend\Support\SeoData;
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

        return view('frontend::pages.view', array_merge(compact('page'), SeoData::page($page)));
    }
}
