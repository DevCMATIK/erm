<?php

namespace App\Http\Client\Zone\Sub\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class SubZoneSerializationController extends Controller
{
    public function index($id)
    {
        $zone = Zone::with('sub_zones')->find($id);
        $sub_zones = $zone->sub_zones;
        return view('client.zone.sub.serialize',compact('zone','sub_zones'));
    }



    public function serialize(Request $request)
    {
        $zones = json_decode($request->zone,true);

        $i = 0;
        foreach($zones as $zone) {
            $zone = SubZone::find($zone['id']);
            $zone->position = $i;
            $zone->save();


            $i++;
        }
        return response()->json(['success' => 'Sub Zonas reordenadas correctamente.']);
    }
}
