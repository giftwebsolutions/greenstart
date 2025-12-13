<?php

namespace Modules\Frontend\Helpers;

use Illuminate\Support\Facades\Route;

class MenuHelper
{
    public static function isActive(array $item): string
    {
        // 1) Direct route match
        if (!empty($item['route']) && self::isCurrentRoute($item['route'], $item['params'] ?? [])) {
            return 'active';
        }

        // 2) Children route match
        if (!empty($item['children']) && is_array($item['children'])) {
            foreach ($item['children'] as $child) {
                if (!empty($child['route']) && self::isCurrentRoute($child['route'], $child['params'] ?? [])) {
                    return 'active';
                }

                // Nested children support (optional)
                if (!empty($child['children']) && is_array($child['children'])) {
                    if (self::isActive($child) === 'active') {
                        return 'active';
                    }
                }
            }
        }

        // 3) URL match (optional fallback)
        if (!empty($item['url'])) {
            $currentPath = trim(request()->path(), '/');
            $itemPath = trim(parse_url($item['url'], PHP_URL_PATH) ?? '', '/');

            if ($itemPath !== '' && $currentPath === $itemPath) {
                return 'active';
            }
        }

        return '';
    }

    /**
     * Check current route name + required route parameters match.
     * Useful for dynamic routes like cms.view with slug param.
     */
    private static function isCurrentRoute(string $routeName, array $params = []): bool
    {
        if (Route::currentRouteName() !== $routeName) {
            return false;
        }

        // If no params provided, route name match is enough
        if (empty($params)) {
            return true;
        }

        // Ensure each param matches current route param
        foreach ($params as $key => $value) {
            if ((string) request()->route($key) !== (string) $value) {
                return false;
            }
        }

        return true;
    }

    /**
     * Generate URL for menu item (recommended usage in blade).
     */
    public static function url(array $item): string
    {
        if (!empty($item['route'])) {
            return route($item['route'], $item['params'] ?? []);
        }

        return $item['url'] ?? '#';
    }
}
