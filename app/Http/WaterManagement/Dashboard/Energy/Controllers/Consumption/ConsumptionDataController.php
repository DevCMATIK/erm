<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers\Consumption;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ConsumptionDataController extends Controller
{
    public function getConsumptionData(Request $request)
    {
        return number_format(ElectricityConsumption::where('sub_zone_id',$request->sub_zone)
                ->where('sensor_type','ee-e-activa')
                ->whereRaw("date between '{$request->start_date}' and '{$request->end_date}'")
                ->sum('consumption') ?? 0,0,',','.');
    }

    public function getZoneConsumptionData(Request $request)
    {
        return number_format(ElectricityConsumption::whereIn('sub_zone_id',function($query) use ($request){
                $query->select('id')
                    ->from('sub_zones')
                    ->where('zone_id',$request->zone);
            })->where('sensor_type','ee-e-activa')
                ->whereRaw("date between '{$request->start_date}' and '{$request->end_date}'")
                ->sum('consumption') ?? 0,0,',','.');
    }
}
