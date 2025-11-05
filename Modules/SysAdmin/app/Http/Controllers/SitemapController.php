<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\File;

class SitemapController extends Controller
{
    public function index()
    {

        // Example file path
        $filePath = base_path('./public/sitemap.xml');

        // Read file content
        $content = file_get_contents($filePath);
        $exists = File::exists($filePath);

        return view('sysadmin::.sitemap.index')->with(['content' => $content, 'exists' => $exists]);
    }

    public function generate(Request $request)
    {
        $sitemap = Sitemap::create();

        // Add your site URLs here dynamically
        $sitemap->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        // Add more URLs as needed

        // Save sitemap to storage
        $sitemap->writeToFile(public_path('sitemap.xml'));

        return redirect()->route('admin.sitemap.index')->with('success', 'Sitemap generated successfully!');
    }
}
