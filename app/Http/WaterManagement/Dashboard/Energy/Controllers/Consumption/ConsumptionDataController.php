<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers\Consumption;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use Carbon\Carbon;
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
            'unit' => 'kWh',
            'title' => $box['label'],
            'icon' => 'fa-calendar'
        ]);
    }

    protected function resolveBox(Request $request)
    {
        $box = array();
        if(
            $request->start_date == Carbon::parse($request->start_date)->startOfMonth()->toDateString()
            &&
            $request->end_date == Carbon::parse($request->end_date)->endOfMonth()->toDateString()
            &&
            Carbon::parse($request->start_date)->format('Y-m') == Carbon::parse($request->end_date)->format('Y-m')
        ) {
            if($request->has('zone')) {
                $zone = Zone::find($request->zone);
                $box['label'] = "Consumo {$zone->name} ".Carbon::parse($request->start_date)->format('Y-m');
            } else {
                $box['label'] = "Consumo ".Carbon::parse($request->start_date)->format('Y-m');
            }

        } else {
            if($request->has('zone')) {
                $zone = Zone::find($request->zone);
                $box['label'] = "Consumo {$zone->name}";
            } else {
                $box['label'] = "Consumo Total";
            }
        }

        if($request->container != 'consumption' || $request->container != 'zone-consumption') {
            $box['bg'] = 'bg-primary-300';
        }


        return $box;
    }
}
