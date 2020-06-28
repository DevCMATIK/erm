<?php

namespace App\Http\WaterManagement\Dashboard\Kpi;

use App\Domain\Client\Zone\Zone;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Illuminate\Support\Arr;
use Sentinel;

class CupLevelsController extends Controller
{
    public function __invoke()
    {
        $zones = $this->getZones();

        $sensors =$this->getSensors($zones);
        $data = array();
        foreach($sensors as $sensor) {
            $lastReport = AnalogousReport::with('device.check_point.sub_zones.zone')
                                        ->where('device_id',$sensor->device_id)
                                        ->where('register_type',$sensor->register_type_id)
                                        ->where('address',$sensor->address)
                                        ->orderBy('id','desc')
                                        ->take(1)
                                        ->first();
            if($lastReport) {
                if($lastReport->result  != '') {
                    array_push($data,[
                        'check_point' => $sensor->check_point,
                        'value' => number_format($lastReport->result,1),
                        'zone' => $lastReport->device->check_point->sub_zones()->first()->zone->name,
                        'sub_zone' => $lastReport->device->check_point->sub_zones()->first()->name,
                        'sub_zone_id' => $lastReport->device->check_point->sub_zones()->first()->id,
                        'position' => $lastReport->device->check_point->sub_zones()->first()->zone->position,
                        'sub_zone_position' => $lastReport->device->check_point->sub_zones()->first()->position,
                        'check_point_id' => $sensor->check_point_id,
                        'device_id' => $sensor->device_id,
                        'label' => $sensor->label,
                        'color' => $lastReport->scale_color
                    ]);
                }
            }
        }
        $data = collect($data)->sortBy('position');

        return view('water-management.dashboard.statistics.cup-levels',compact('data'));
    }

    protected function getDevicesId($zones)
    {
        $ids = array();
        foreach($zones as $zone) {
            foreach($zone->sub_zones as $sub_zone) {
                foreach($sub_zone->sub_elements as $sub_element) {
                    if(Sentinel::getUser()->inSubZone($sub_zone->id)) {
                        array_push($ids,$sub_element->device_id);
                    }
                }
            }
        }

        return $ids;
    }

    protected function getZones()
    {
        return Zone::with([
            'sub_zones.configuration',
            'sub_zones.sub_elements'
        ])->get()->filter(function($item){
            return $item->sub_zones->filter(function($sub_zone) {
                    return Sentinel::getUser()->inSubZone($sub_zone->id) && isset($sub_zone->configuration);
                })->count() > 0;
        });
    }

    protected function getSensors($zones)
    {
        return Sensor::leftJoin('devices','devices.id','=','sensors.device_id')
            ->leftJoin('check_points','check_points.id','=','devices.check_point_id')
            ->leftJoin('check_point_labels','devices.id','=','check_point_labels.device_id')
            ->leftJoin('check_point_types','check_point_types.id','=','check_points.type_id')
            ->leftJoin('addresses','addresses.id','=','sensors.address_id')
            ->where(('sensors.type_id',1)or('sensors.type_id',32))
            ->whereNull('devices.deleted_at')
            ->whereNull('check_points.deleted_at')
            ->whereRaw("(check_point_types.slug = 'copas' or check_point_types.slug = 'relevadoras') and addresses.register_type_id = 11")
            ->whereIn('devices.id',$this->getDevicesId($zones))
            ->selectRaw('check_points.name as check_point,check_points.id as check_point_id,check_point_labels.label as label,sensors.address_number as address,addresses.register_type_id,devices.id as device_id')
            ->get();
    }
}
