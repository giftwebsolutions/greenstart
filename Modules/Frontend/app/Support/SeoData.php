<?php

namespace Modules\Frontend\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\SysAdmin\Models\Settings;

class SeoData
{
    protected static ?array $settingsCache = null;

    public static function settings(): array
    {
        return static::$settingsCache ??= Settings::getSettingByType('core');
    }

    public static function defaults(?array $settings = null): array
    {
        $settings ??= static::settings();

        $siteName = $settings['site_name'] ?? config('app.name');
        $description = $settings['meta_description'] ?? $settings['description'] ?? $siteName;
        $keywords = $settings['meta_keywords'] ?? $settings['keywords'] ?? '';

        return [
            'site_name' => $siteName,
            'title' => $siteName,
            'description' => Str::limit(strip_tags((string) $description), 160, ''),
            'keywords' => $keywords,
            'canonical' => url()->current(),
            'robots' => 'index,follow',
            'image' => asset('assets/img/logo.png'),
            'type' => 'website',
            'twitter_card' => 'summary_large_image',
        ];
    }

    public static function basic(string $title, array $overrides = [], array $structuredData = []): array
    {
        $defaults = static::defaults();

        $seo = array_merge($defaults, [
            'title' => trim($title . ' | ' . $defaults['site_name']),
        ], $overrides);

        if (!Str::contains((string) $seo['title'], $defaults['site_name'])) {
            $seo['title'] = trim($seo['title'] . ' | ' . $defaults['site_name']);
        }

        return [
            'seo' => $seo,
            'structuredData' => array_values(array_filter(array_merge([
                static::organization(),
            ], $structuredData))),
        ];
    }

    public static function page($page = null, array $overrides = []): array
    {
        if (!$page) {
            return static::basic('Page');
        }

        $title = $page->title ?: $page->name ?: config('app.name');
        $description = $page->description ?: Str::limit(strip_tags((string) $page->content), 160, '');

        return static::basic($title, array_merge([
            'description' => $description,
            'keywords' => $page->keywords ?: static::defaults()['keywords'],
        ], $overrides), [
            static::breadcrumb([
                ['name' => 'Home', 'url' => route('frontend.home')],
                ['name' => $title, 'url' => $overrides['canonical'] ?? url()->current()],
            ]),
        ]);
    }

    public static function blogIndex(?string $heading = null, array $overrides = []): array
    {
        $title = $heading ?: 'Blog';

        return static::basic($title, $overrides, [
            static::breadcrumb([
                ['name' => 'Home', 'url' => route('frontend.home')],
                ['name' => $title, 'url' => $overrides['canonical'] ?? url()->current()],
            ]),
        ]);
    }

    public static function blogShow($blog, array $overrides = []): array
    {
        $title = $blog->title ?? 'Blog';
        $description = $blog->description ?: Str::limit(strip_tags((string) $blog->content), 160, '');

        return static::basic($title, array_merge([
            'description' => $description,
            'keywords' => $blog->keywords ?: static::defaults()['keywords'],
            'type' => 'article',
        ], $overrides), [
            static::breadcrumb([
                ['name' => 'Home', 'url' => route('frontend.home')],
                ['name' => 'Blog', 'url' => route('frontend.blog.index')],
                ['name' => $title, 'url' => $overrides['canonical'] ?? url()->current()],
            ]),
            static::article($blog),
        ]);
    }

    public static function productList(string $title, array $overrides = []): array
    {
        return static::basic($title, $overrides, [
            static::breadcrumb([
                ['name' => 'Home', 'url' => route('frontend.home')],
                ['name' => $title, 'url' => $overrides['canonical'] ?? url()->current()],
            ]),
        ]);
    }

    public static function productShow($product, array $overrides = []): array
    {
        $title = $product->title ?? 'Product';
        $description = $product->short_description ?: Str::limit(strip_tags((string) $product->description), 160, '');

        return static::basic($title, array_merge([
            'description' => $description,
            'keywords' => $product->keywords ?: static::defaults()['keywords'],
            'image' => $product->thumb_url ?: static::defaults()['image'],
            'type' => 'product',
        ], $overrides), [
            static::breadcrumb([
                ['name' => 'Home', 'url' => route('frontend.home')],
                ['name' => 'Shop', 'url' => route('frontend.shop.categories')],
                ['name' => $title, 'url' => $overrides['canonical'] ?? url()->current()],
            ]),
            static::product($product),
        ]);
    }

    public static function organization(?array $settings = null): array
    {
        $defaults = static::defaults($settings);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $defaults['site_name'],
            'url' => url('/'),
            'logo' => $defaults['image'],
        ];
    }

    public static function breadcrumb(array $items): array
    {
        $elements = [];

        foreach ($items as $index => $item) {
            if (empty($item['name']) || empty($item['url'])) {
                continue;
            }

            $elements[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $elements,
        ];
    }

    public static function article($blog): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $blog->title ?? '',
            'description' => $blog->description ?: Str::limit(strip_tags((string) $blog->content), 160, ''),
            'datePublished' => optional($blog->published_at)->toAtomString() ?: null,
            'mainEntityOfPage' => url()->current(),
        ];
    }

    public static function product($product): array
    {
        $offer = [];

        if (!empty($product->sales_price)) {
            $offer = [
                '@type' => 'Offer',
                'priceCurrency' => 'INR',
                'price' => $product->sales_price,
                'availability' => 'https://schema.org/InStock',
                'url' => url()->current(),
            ];
        }

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->title ?? '',
            'description' => $product->short_description ?: Str::limit(strip_tags((string) $product->description), 160, ''),
            'image' => $product->thumb_url ?: null,
            'sku' => $product->sku ?? null,
            'offers' => $offer ?: null,
        ], fn ($value) => !is_null($value) && $value !== '');
    }
}
