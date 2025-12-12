<?php

namespace Modules\Frontend\Helpers;

use Illuminate\Support\Facades\Route;

class MenuHelper
{
    public static function isActive($item)
    {
        if (isset($item['route']) && $item['route']) {
            return Route::currentRouteName() === $item['route'] ? 'active' : '';
        }

        if (isset($item['children'])) {
            foreach ($item['children'] as $child) {
                if (!empty($child['route']) && Route::currentRouteName() === $child['route']) {
                    return 'active';
                }
            }
        }

        return '';
    }
}
