<?php

namespace App\Http\WaterManagement\Group\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\System\User\User;
use App\Domain\WaterManagement\Group\Group;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class GroupSubZonesController extends Controller
{
    public function index($group_id)
    {
        $group = Group::with('sub_zones')->find($group_id);
        $zones = Zone::with('sub_zones')->get();
        return view('water-management.group.sub-zones',compact('group','zones'));
    }

    public function store(Request $request,$id)
    {
        $group = Group::with('users')->find($id);
        $group->sub_zones()->sync($request->sub_zones);
        $groups = Group::with('users.sub_zones','sub_zones.zone.production_areas')->get();
        $users = User::get();
        foreach($users as $user) {
            $user->sub_zones()->detach();
            $user->production_areas()->detach();
        }
        foreach($groups as $group){
            $pa = array();
            foreach($group->sub_zones as $sub_zone) {
                array_push($pa,$sub_zone->zone->production_areas->pluck('id')->toArray());
            }

            foreach($group->users as $user) {
               $user->production_areas()->syncWithoutDetaching(collect($pa)->collapse()->unique());
               $user->sub_zones()->syncWithoutDetaching($group->sub_zones->pluck('id')->unique());
            }
        }

        return response()->json(['success' => 'Grupos y usuarios sincronizados']);

    }
}
