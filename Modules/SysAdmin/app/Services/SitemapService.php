<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Services;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Filesystem\Filesystem;
use Modules\SysAdmin\Models\Blog;
use Modules\SysAdmin\Models\BlogCategory;
use Modules\SysAdmin\Models\Page;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Models\ProductCategory;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

final class SitemapService
{
    public function __construct(private readonly Filesystem $files) {}

    /**
     * @return array{path: string, url_count: int, bytes: int, generated_at: Carbon}
     */
    public function generate(?string $targetPath = null): array
    {
        $sitemap = Sitemap::create();

        $this->addStaticRoutes($sitemap);
        $this->addPages($sitemap);
        $this->addProductCategories($sitemap);
        $this->addProducts($sitemap);
        $this->addBlogCategories($sitemap);
        $this->addBlogs($sitemap);

        $path = $targetPath ?: public_path('sitemap.xml');
        $this->files->ensureDirectoryExists(dirname($path));
        $xml = $sitemap->render();
        $this->files->replace($path, $xml);
        clearstatcache(true, $path);

        return [
            'path' => $path,
            'url_count' => $this->countUrls($path),
            'bytes' => (int) ($this->files->size($path) ?: strlen($xml)),
            'generated_at' => now(),
        ];
    }

    /**
     * @return array{exists: bool, path: string, url: string, bytes: int, url_count: int, modified_at: ?Carbon, preview: string}
     */
    public function status(): array
    {
        $path = public_path('sitemap.xml');
        $exists = $this->files->exists($path);

        return [
            'exists' => $exists,
            'path' => $path,
            'url' => url('/sitemap.xml'),
            'bytes' => $exists ? (int) $this->files->size($path) : 0,
            'url_count' => $exists ? $this->countUrls($path) : 0,
            'modified_at' => $exists ? Carbon::createFromTimestamp((int) $this->files->lastModified($path)) : null,
            'preview' => $exists ? $this->preview($path) : '',
        ];
    }

    private function addStaticRoutes(Sitemap $sitemap): void
    {
        foreach ([
            ['frontend.home', Url::CHANGE_FREQUENCY_DAILY, 1.0],
            ['frontend.shop.index', Url::CHANGE_FREQUENCY_DAILY, 0.9],
            ['frontend.shop.new-arrivals', Url::CHANGE_FREQUENCY_DAILY, 0.8],
            ['frontend.blog.index', Url::CHANGE_FREQUENCY_DAILY, 0.8],
            ['frontend.about', Url::CHANGE_FREQUENCY_MONTHLY, 0.6],
            ['frontend.faqs', Url::CHANGE_FREQUENCY_MONTHLY, 0.6],
            ['frontend.contact', Url::CHANGE_FREQUENCY_MONTHLY, 0.6],
            ['frontend.enquiry', Url::CHANGE_FREQUENCY_MONTHLY, 0.5],
        ] as [$routeName, $frequency, $priority]) {
            if (! app('router')->has($routeName)) {
                continue;
            }

            $sitemap->add(
                Url::create(route($routeName))
                    ->setChangeFrequency($frequency)
                    ->setPriority($priority)
            );
        }
    }

    private function addPages(Sitemap $sitemap): void
    {
        $namedRoutes = [
            'home' => 'frontend.home',
            'about' => 'frontend.about',
            'faq' => 'frontend.faqs',
            'faqs' => 'frontend.faqs',
            'contact' => 'frontend.contact',
            'enquiry' => 'frontend.enquiry',
            'blog' => 'frontend.blog.index',
            'shop' => 'frontend.shop.index',
        ];

        Page::query()
            ->active()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->select(['id', 'slug', 'updated_at'])
            ->chunkById(500, function ($pages) use ($sitemap, $namedRoutes): void {
                foreach ($pages as $page) {
                    $routeName = $namedRoutes[$page->slug] ?? 'frontend.cms.view';
                    $parameters = $routeName === 'frontend.cms.view' ? ['slug' => $page->slug] : [];
                    $this->addUrl($sitemap, route($routeName, $parameters), $page->updated_at, Url::CHANGE_FREQUENCY_MONTHLY, 0.6);
                }
            });
    }

    private function addProductCategories(Sitemap $sitemap): void
    {
        ProductCategory::query()
            ->where('status', 1)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->select(['id', 'slug', 'updated_at'])
            ->chunkById(500, function ($categories) use ($sitemap): void {
                foreach ($categories as $category) {
                    $this->addUrl($sitemap, route('frontend.shop.category', ['slug' => $category->slug]), $category->updated_at, Url::CHANGE_FREQUENCY_WEEKLY, 0.8);
                }
            });
    }

    private function addProducts(Sitemap $sitemap): void
    {
        Product::query()
            ->published()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->select(['id', 'slug', 'updated_at'])
            ->chunkById(500, function ($products) use ($sitemap): void {
                foreach ($products as $product) {
                    $this->addUrl($sitemap, route('frontend.shop.product.show', ['slug' => $product->slug]), $product->updated_at, Url::CHANGE_FREQUENCY_WEEKLY, 0.8);
                }
            });
    }

    private function addBlogCategories(Sitemap $sitemap): void
    {
        BlogCategory::query()
            ->active()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->select(['id', 'slug', 'updated_at'])
            ->chunkById(500, function ($categories) use ($sitemap): void {
                foreach ($categories as $category) {
                    $this->addUrl($sitemap, route('frontend.blog.category', ['slug' => $category->slug]), $category->updated_at, Url::CHANGE_FREQUENCY_WEEKLY, 0.7);
                }
            });
    }

    private function addBlogs(Sitemap $sitemap): void
    {
        Blog::query()
            ->active()
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->select(['id', 'slug', 'updated_at'])
            ->chunkById(500, function ($blogs) use ($sitemap): void {
                foreach ($blogs as $blog) {
                    $this->addUrl($sitemap, route('frontend.blog.show', ['slug' => $blog->slug]), $blog->updated_at, Url::CHANGE_FREQUENCY_MONTHLY, 0.7);
                }
            });
    }

    private function addUrl(Sitemap $sitemap, string $location, mixed $lastModified, string $frequency, float $priority): void
    {
        $tag = Url::create($location)
            ->setChangeFrequency($frequency)
            ->setPriority($priority);

        if ($date = $this->date($lastModified)) {
            $tag->setLastModificationDate($date);
        }

        $sitemap->add($tag);
    }

    private function date(mixed $value): ?Carbon
    {
        if ($value instanceof DateTimeInterface) {
            return Carbon::instance($value);
        }

        if (is_numeric($value) && (int) $value > 0) {
            return Carbon::createFromTimestamp((int) $value);
        }

        return null;
    }

    private function countUrls(string $path): int
    {
        $handle = fopen($path, 'rb');
        if ($handle === false) {
            return 0;
        }

        $count = 0;
        $tail = '';

        try {
            while (! feof($handle)) {
                $chunk = $tail.(string) fread($handle, 65536);
                $count += substr_count($chunk, '<url>');
                $tail = substr($chunk, -4);
            }
        } finally {
            fclose($handle);
        }

        return $count;
    }

    private function preview(string $path): string
    {
        $handle = fopen($path, 'rb');
        if ($handle === false) {
            return '';
        }

        try {
            return (string) fread($handle, 12000);
        } finally {
            fclose($handle);
        }
    }
}
