<?php

namespace App\Http\User\SubZone\Controllers;

use App\Domain\Client\ProductionArea\ProductionArea;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\System\User\User;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Illuminate\Support\Arr;

class UserSubZonesController extends Controller
{
    public function index($id)
    {
        $user = User::with(['sub_zones','production_areas'])->find($id);
        $productionAreas = ProductionArea::has('zones')->get();
        $zones = Zone::with('sub_zones')->get();

        return view('user.sub-zones.index',compact('user','productionAreas','zones'));
    }

    public function handleProductionAreas(Request $request,$id)
    {
        $user = User::with(['production_areas','sub_zones'])->find($id);

        if($request->has('production_areas')) {
            $this->attachSubZones($user,$request->production_areas);
            return response()->json(['success' => 'Se han otorgado los permisos correctamente']);
        } else {

            $this->detachAll($user);
            return response()->json(['success' => 'Se han eliminado todas las relaciones del usuario.']);
        }
    }

    public function getUserSubZones($user_id){
        $user = User::with(['sub_zones.zone','production_areas.zones.sub_zones'])->find($user_id);
        $sub_zones = array();
        $zones = array();
        foreach($user->production_areas  as $pa) {
            array_push($zones,$pa->zones->toArray());


            foreach($pa->zones->toArray() as $zone){
                array_push($sub_zones,$zone['sub_zones']);
            }
        }
        $sub_zones = collect(Arr::collapse($sub_zones))->unique('id');
        $zones = collect(Arr::collapse($zones))->unique('id');
        return view('user.sub-zones.partials.sub-zones',compact('user','sub_zones','zones'));
    }

    public function storeSubZones(Request $request,$id)
    {
        $user = User::with('sub_zones')->find($id);

       if($request->has('sub_zones')) {
            foreach($request->sub_zones as $sub_zone) {
                if(!$user->inSubZone($sub_zone)) {
                    $user->sub_zones()->attach($sub_zone);
                }
            }
            foreach(SubZone::whereNotIn('id',$request->sub_zones)->get() as $sub){
                if($user->inSubZone($sub->id)) {
                    $user->sub_zones()->detach($sub->id);
                }
            }
           return response()->json(['success' => 'Se han asignado las sub zonas correctamente']);

       } else {
            $user->sub_zones()->detach();
           return response()->json(['success' => 'Se han quitado todas las sub zonas']);
       }
    }

    protected function detachAll(User $user)
    {
        if ($user->production_areas()->count() > 0) {
           $user->production_areas()->detach();
        }

        if($user->sub_zones()->count() > 0) {
            $user->sub_zones()->detach();
        }
    }

    protected function attachSubZones(User $user,$production_areas)
    {
        $diff = array_diff($user->production_areas->pluck('id')->toArray(),$production_areas);
        foreach(array_values($diff) as $pa) {
            if ($user->inProductionArea($pa)){
                $zones = ProductionArea::with('zones.sub_zones')->find($pa)->zones;
                foreach ($zones as $zone) {
                    $user->sub_zones()->detach($zone->sub_zones->pluck('id')->toArray());
                }
                $user->production_areas()->detach($pa);
            }
        }

        foreach($production_areas as $production_area) {
            if(!$user->inProductionArea($production_area)) {
                $user->production_areas()->attach($production_area);
            }
            $productionAreas = ProductionArea::with('zones.sub_zones')->find($production_area);
            foreach($productionAreas->zones as $zone) {
                foreach($zone->sub_zones as $sub_zone) {
                    if(!$user->inSubZone($sub_zone->id)) {
                        $user->sub_zones()->attach($sub_zone->id);
                    }
                }
            }
        }
    }
}
