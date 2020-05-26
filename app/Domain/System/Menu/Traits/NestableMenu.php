<?php

namespace App\Domain\System\Menu\Traits;


trait NestableMenu
{
    protected $menus;

    public static function getNested($parent = 0){
        $menus = static::getMenu();
        $menu = $menus->filter(function ($value, $key) use ($parent) {
                return $value->parent_id == $parent;
            })->map(function ($item) {
                if ($item->userHasPermission()) {
                   $item->children = self::getNested($item->id);
                   if (isset($item->route) && isActiveRoute($item->route)) {
                       $item->class = 'active';
                   } else {
                       $item->class = '';
                   }

                   if (count($item->children) > 0) {
                        $item->children->each(function($child) use($item){
                            if ($child['class'] == 'active') {
                               $item->class = 'open active';
                            }
                        });
                   }
                   return $item;
                }
        })->filter(function($item) {
            return $item !== null;
        });

        return $menu;
    }
}
