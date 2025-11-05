<?php

namespace Modules\SysAdmin\Helpers;

use Modules\SysAdmin\Models\Menus;
use Modules\SysAdmin\Models\MenuItems;

class MenuHelper
{
    public static function select($name = "menu", $menulist = array(), $attributes = array())
    {
        $attribute_string = "";
        if (count($attributes) > 0) {
            $attribute_string = str_replace(
                "=",
                '="',
                http_build_query($attributes, '', '" ', PHP_QUERY_RFC3986)
            ) . '"';
        }
        $html = '<select class="form-select col-6" name="' . $name . '" ' . $attribute_string . '>';
        foreach ($menulist as $key => $val) {
            $active = '';
            if (request()->input('menu') == $key) {
                $active = 'selected="selected"';
            }
            $html .= '<option ' . $active . ' value="' . $key . '">' . $val . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public static function getByName($name)
    {
        $menu = Menus::byName($name);
        return is_null($menu) ? [] : self::get($menu->id);
    }

    public static function get($menu_id)
    {
        $menuItem = new MenuItems;
        $menu_list = $menuItem->getall($menu_id);

        $roots = $menu_list->where('menu', (int) $menu_id)->where('parent', 0);

        $items = self::tree($roots, $menu_list);
        return $items;
    }

    private static function tree($items, $all_items)
    {
        $data_arr = array();
        $i = 0;
        foreach ($items as $item) {
            $data_arr[$i] = $item->toArray();
            $find = $all_items->where('parent', $item->id);

            $data_arr[$i]['child'] = array();

            if ($find->count()) {
                $data_arr[$i]['child'] = self::tree($find, $all_items);
            }

            $i++;
        }

        return $data_arr;
    }
}
