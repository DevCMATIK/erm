<?php

namespace App\Http\Client\ProductionArea\Controllers;

use App\Domain\Client\ProductionArea\ProductionArea;
use App\Domain\Client\Zone\Zone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ProductionAreaZonesController extends Controller
{
    public function index($id)
    {
        $productionArea = ProductionArea::with('zones')->find($id);
        $zones = Zone::get();
        return view('client.production-area.zones',compact('productionArea','zones'));
    }

    public function storeZones(Request $request, $id)
    {
        if ($request->zones) {
            $productionArea = ProductionArea::find($id);
                if(count($productionArea->zones) > 0 ){
                    $productionArea->zones()->detach();
                }
                $productionArea->zones()->attach($request->zones);

                $production_area = ProductionArea::with(['zones.sub_zones','users'])->findOrFail($id);

                foreach($production_area->zones as $zone) {
                    foreach($zone->sub_zones as $sub_zone) {
                        $sub_zone->users()->syncWithoutDetaching($production_area->users->pluck('id')->toArray() ?? []);

                    }
                }
                return response()->json(['success' => 'Zonas Asignadas.'],200);

        } else {
            return response()->json(['error' => 'Debe seleccionar almenos 1 Zona.']);
        }

    }
}
