<?php

namespace App\Http\Client\ProductionArea\Controllers;

use App\Domain\Client\ProductionArea\ProductionArea;
use App\Domain\System\User\User;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ProductionAreaUsersController extends Controller
{
    public function index($production_area_id)
    {
        $production_area = ProductionArea::with('users')->findOrFail($production_area_id);
        $users = User::get();
        return view('client.production-area.users',compact('production_area','users'));
    }

    public function storeUsers(Request $request,$id)
    {
        $production_area = ProductionArea::with(['zones.sub_zones','users'])->findOrFail($id);
        $not_in = $production_area->users->whereNotIn('id',$request->users ?? [])->pluck('id')->toArray();

            $production_area->users()->syncWithoutDetaching($request->users ?? []);
            $production_area->users()->detach($not_in);
            foreach($production_area->zones as $zone) {
                foreach($zone->sub_zones as $sub_zone) {
                    $sub_zone->users()->syncWithoutDetaching($request->users ?? []);
                    $sub_zone->users()->detach($not_in);
                }
            }

        return response()->json(['success' => 'Se han sincronizado los usuarios'],200);
    }
}
