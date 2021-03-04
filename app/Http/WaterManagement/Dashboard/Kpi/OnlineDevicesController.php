<?php

namespace App\Http\WaterManagement\Dashboard\Kpi;

use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Device;
use App\App\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Sentinel;

class OnlineDevicesController extends Controller
{
    public function __invoke()
    {

        $devices =  Device::with('report','check_point.sub_zones.zone')
           ->whereIn('id',$this->getDevicesId())->get();

        $total = $devices->count();


        $offline = $devices-->filter(function($device){
                if($device->from_dpl === 1) {
                    $state =  DB::connection('dpl')->table('reports')
                        ->where('grd_id',$device->internal_id)
                        ->first()->state;
                } else {
                    if($device->from_bio === 1) {
                        $state =  DB::connection('bioseguridad')->table('reports')
                            ->where('grd_id',$device->internal_id)
                            ->first()->state;
                    } else {
                        $state = $device->report->state ?? 0;
                    }
                }
                return $state === 0;
            })->count();


        return "{$offline}/{$total}";
    }

    protected function getDevicesId()
    {
        $ids = array();
        $zones = Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['sub_zones' => $filter,'sub_zones.sub_elements'])->get();
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
}
