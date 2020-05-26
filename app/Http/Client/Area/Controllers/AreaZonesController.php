<?php

namespace App\Http\Client\Area\Controllers;

use App\Domain\Client\Area\Area;
use App\Domain\Client\Zone\Zone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class AreaZonesController extends Controller
{
    public function index($id)
    {
        $area = Area::with('zones')->findOrFail($id);
        $zones = Zone::get();
        return view('client.area.area-zones',compact('zones','area'));
    }

    public function storeZones(Request $request, $id)
    {

        if ($request->zones) {
            $area = Area::find($id);

            foreach($request->zones as $zone){
                $z = Zone::find($zone);
                $z->area_id = $id;
                $z->save();
            }
            return response()->json(['success' => 'Zonas Asignadas.'],200);

        } else {
            return response()->json(['error' => 'Debe seleccionar almenos 1 Zona.']);
        }

    }
}
