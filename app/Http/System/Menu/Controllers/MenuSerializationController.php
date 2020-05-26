<?php

namespace App\Http\System\Menu\Controllers;

use App\Domain\System\Menu\Menu;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class MenuSerializationController extends Controller
{
    public function index()
    {
        $menu = $this->getNestableMenu();
        return view('system.menu.serialization.index',compact('menu'));
    }

    public function getNestableMenu()
    {
        $menu = new Menu();
        return $menu->getNested();
    }

    public function serialize(Request $request)
    {
        $menu = json_decode($request->menu,true);

        $i = 0;
        foreach($menu as $m) {
            $menuItem = Menu::find($m['id']);
            $menuItem->position = $i;
            $menuItem->parent_id = null;
            $menuItem->save();

            $x = 0;
            if ( isset($m['children']) && count($m['children']) > 0) {
                foreach ($m['children'] as $second) {
                    $menuItem = Menu::find($second['id']);
                    $menuItem->position = $x;
                    $menuItem->parent_id = $m['id'];
                    $menuItem->save();
                    $z = 0;
                    if (isset($second['children']) && count($second['children']) > 0) {
                        foreach ($second['children'] as $third) {
                            $menuItem = Menu::find($third['id']);
                            $menuItem->position = $z;
                            $menuItem->parent_id = $second['id'];
                            $menuItem->save();
                            $z++;
                        }
                    }
                    $x++;
                }
            }
            $i++;
        }
        return response()->json(['success' => 'Menu Serializado correctamente.']);
    }
}
