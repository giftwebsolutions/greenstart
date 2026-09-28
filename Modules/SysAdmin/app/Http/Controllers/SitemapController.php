<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\SysAdmin\Services\SitemapService;

class SitemapController extends Controller
{
    public function index()
    {
        return view('sysadmin::sitemap.index');
    }

    public function generate(SitemapService $sitemaps)
    {
        $result = $sitemaps->generate();

        return redirect()
            ->route('sysadmin.media.sitemap.index')
            ->with('success', number_format($result['url_count']).' sitemap URLs generated.');
    }
}
