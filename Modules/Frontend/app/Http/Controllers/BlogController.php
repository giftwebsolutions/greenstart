<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Frontend\Support\SeoData;
use Modules\SysAdmin\Interfaces\BlogInterface;
use Modules\SysAdmin\Interfaces\BlogCategoryInterface;
use Modules\SysAdmin\Models\Page;

class BlogController extends Controller
{
    public function __construct(
        protected BlogInterface $blogRepo,
        protected BlogCategoryInterface $blogCategoryRepo
    ) {}


    private function recentPostsForList(int $limit = 4)
    {
        return $this->blogRepo->recentFrontend($limit);
    }

    private function recentPostsForView(int $excludeId, int $limit = 4)
    {
        return $this->blogRepo->recentFrontend($limit, $excludeId);
    }

    private function sidebarData(array $options = []): array
    {
        $excludeId = $options['excludeId'] ?? null;
        $activeCategorySlug = $options['activeCategorySlug'] ?? null;
        $q = $options['q'] ?? request('q');

        $categories = $this->blogCategoryRepo->frontendWithCount();
        $recentPosts = $excludeId
            ? $this->recentPostsForView($excludeId)
            : $this->recentPostsForList();

        // tags: from current blog keywords OR from recent posts keywords
        $tags = collect($options['keywords'] ?? [])
            ->when(empty($options['keywords'] ?? []), function ($c) use ($recentPosts) {
                return $recentPosts->pluck('keywords')->filter();
            })
            ->flatMap(fn($k) => array_map('trim', explode(',', (string)$k)))
            ->filter()
            ->unique()
            ->take(15)
            ->values();

        return compact('categories', 'recentPosts', 'tags', 'activeCategorySlug', 'q');
    }

    /* =========================
     | Actions
     ========================= */

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 12);

        $blogs   = $this->blogRepo->paginateFrontend($perPage);
        $sidebar = $this->sidebarData();

        $blogPage   = Page::where('slug', 'blog')->active()->first();
        $seoPayload = $blogPage ? SeoData::page($blogPage) : SeoData::blogIndex();

        return view('frontend::blogs.index', array_merge(
            compact('blogs'),
            $sidebar,
            $seoPayload
        ));
    }

    public function show(string $slug)
    {
        $blog = $this->blogRepo->findFrontendBySlug($slug);

        $related = $this->blogRepo->relatedFrontend($blog->id, $blog->category_id, 6);

        $sidebar = $this->sidebarData([
            'excludeId' => $blog->id,
            'activeCategorySlug' => optional($blog->category)->slug,
            'keywords' => [$blog->keywords],
        ]);

        return view('frontend::blogs.view', array_merge(
            compact('blog', 'related'),
            $sidebar,
            SeoData::blogShow($blog)
        ));
    }

    public function category(string $slug, Request $request)
    {
        $perPage = (int) $request->get('per_page', 12);

        $category = $this->blogCategoryRepo->findBySlug($slug);
        $blogs = $this->blogRepo->frontendBaseQuery()
            ->where('category_id', $category->id)
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        $sidebar = $this->sidebarData([
            'activeCategorySlug' => $category->slug,
        ]);

        return view('frontend::blogs.category', array_merge(
            compact('category', 'blogs'),
            $sidebar,
            SeoData::blogIndex($category->name)
        ));
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $perPage = (int) $request->get('per_page', 12);

        $blogs = $this->blogRepo->searchFrontendPaginate($q, $perPage);

        $sidebar = $this->sidebarData([
            'q' => $q,
        ]);

        $heading = $q !== '' ? "Blog Search: {$q}" : 'Blog Search';

        return view('frontend::blogs.search', array_merge(
            compact('q', 'blogs'),
            $sidebar,
            SeoData::blogIndex($heading, ['robots' => 'noindex,follow'])
        ));
    }
}
