<?php

namespace App\Http\Client\Zone\Controllers;

use App\Domain\Client\Zone\Zone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ZoneSerializationController extends Controller
{
    public function index()
    {
        $zones = Zone::get();
        return view('client.zone.serialize',compact('zones'));
    }



    public function serialize(Request $request)
    {
        $zones = json_decode($request->zone,true);

        $i = 0;
        foreach($zones as $zone) {
            $zone = Zone::find($zone['id']);
            $zone->position = $i;
            $zone->save();


            $i++;
        }
        return response()->json(['success' => 'Zonas reordenadas correctamente.']);
    }
}
