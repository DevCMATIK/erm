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
        $box = $this->resolveBox($request);
        return view('water-management.dashboard.energy.components.main-box',[
            'bg' => $box['bg'] ?? 'bg-primary',
            'value' =>  $value,
            'measure' => 'kWh',
            'title' => $box['label'],
            'icon' => 'fa-calendar'
        ]);
    }

    protected function resolveBox(Request $request)
    {
        $box = array();
        if($request->has('zone')) {
            $zone = Zone::find($request->zone);
            if($request->start_date == now()->startOfMonth()->toDateString() && $request->end_date == now()->endOfMonth()->toDateString()) {
                $box['label'] = "Consumo {$zone->name} mes actual";
            } else {
                if($request->start_date == now()->subMonth()->startOfMonth()->toDateString() && $request->end_date == now()->subMonth()->endOfMonth()->toDateString()) {
                    $box['label'] = "Consumo {$zone->name} mes pasado";
                    $box['bg'] = 'bg-primary-300';
                } else {
                    $box['label'] = "Consumo {$zone->name}";
                }
            }
        } else {
            if($request->start_date == now()->startOfMonth()->toDateString() && $request->end_date == now()->endOfMonth()->toDateString()) {
                $box['label'] = "Consumo mes actual";
            } else {
                if($request->start_date == now()->subMonth()->startOfMonth()->toDateString() && $request->end_date == now()->subMonth()->endOfMonth()->toDateString()) {
                    $box['label'] = "Consumo mes pasado";
                    $box['bg'] = 'bg-primary-300';
                } else {
                    $box['label'] = "Consumo total";
                }
            }
        }

        return $box;
    }
}
