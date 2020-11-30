<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers\Consumption;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ConsumptionDataController extends Controller
{
    public function getConsumptionData(Request $request)
    {
       return $this->getMainBox($request,ElectricityConsumption::where('sub_zone_id',$request->sub_zone)
           ->where('sensor_type','ee-e-activa')
           ->whereRaw("date between '{$request->start_date}' and '{$request->end_date}'")
           ->sum('consumption'));
    }

    public function getZoneConsumptionData(Request $request)
    {
        return $this->getMainBox($request,ElectricityConsumption::
            whereIn('sub_zone_id',function($query) use ($request){
            $query->select('id')
                ->from('sub_zones')
                ->where('zone_id',$request->zone);
        })->where('sensor_type','ee-e-activa')
            ->whereRaw("date between '{$request->start_date}' and '{$request->end_date}'")
            ->sum('consumption'));
    }

    protected function getMainBox(Request $request,$value)
    {
        $value = ($value < 0)?0:$value;
        return view('water-management.dashboard.energy.components.main-box',[
            'bg' => 'bg-primary',
            'value' =>  $value,
            'measure' => 'kWh',
            'title' => $this->resolveLabel($request),
            'icon' => 'fa-calendar'
        ]);
    }

    protected function resolveLabel(Request $request)
    {
        if($request->has('zone')) {
            $zone = Zone::find($request->zone);
            if($request->start_date == now()->startOfMonth()->toDateString() && $request->end_date == now()->endOfMonth()->toDateString()) {
                return "Consumo {$zone->name} mes actual";
            } else {
                if($request->start_date == now()->subMonth()->startOfMonth()->toDateString() && $request->end_date == now()->subMonth()->endOfMonth()->toDateString()) {
                    return "Consumo {$zone->name} mes pasado";
                } else {
                    return "Consumo {$zone->name}";
                }
            }
        } else {
            if($request->start_date == now()->startOfMonth()->toDateString() && $request->end_date == now()->endOfMonth()->toDateString()) {
                return "Consumo mes actual";
            } else {
                if($request->start_date == now()->subMonth()->startOfMonth()->toDateString() && $request->end_date == now()->subMonth()->endOfMonth()->toDateString()) {
                    return "Consumo mes pasado";
                } else {
                    return "Consumo total";
                }
            }
        }
    }
}
