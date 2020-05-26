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
                return response()->json(['success' => 'Zonas Asignadas.'],200);

        } else {
            return response()->json(['error' => 'Debe seleccionar almenos 1 Zona.']);
        }

    }
}
