<?php

namespace App\Http\Client\Zone\Sub\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Sub\SubZoneHourValue;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class SubZoneEnergyCostController extends Controller
{
    public function index()
    {
        $sub_zones = SubZone::with(['energy_cost','zone'])->get();

        return view('client.zone.sub.energy-cost',compact('sub_zones'));
    }

    public function store(Request $request)
    {

        if($request->has('energy_costs')) {
            $i = 0;
            foreach($request->sub_zones as $sub_zone){
                if($request->energy_costs[$i] != '') {
                    SubZoneHourValue::updateOrCreate([
                        'sub_zone_id' => $sub_zone
                    ],[
                        'hour_cost' => $request->energy_costs[$i]
                    ]);
                }
                $i++;

            }
            return response()->json(['success' => 'Costos Hora Almacenados correctamente']);
        } else {
            return response()->json(['error','Indique almenos un costo/hora.'],401);
        }
    }
}
