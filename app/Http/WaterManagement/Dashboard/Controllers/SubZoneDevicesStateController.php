<?php

namespace App\Http\WaterManagement\Dashboard\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SubZoneDevicesStateController extends Controller
{
    public function __invoke($sub_zone_id)
    {
        $sub_zone = SubZone::with('sub_elements.check_point.devices.report')
                    ->find($sub_zone_id);
        return $this->getDevicesStatus($sub_zone);
    }

    protected function getDevicesStatus($sub_zone)
    {
        $offline = 0;
        foreach($sub_zone->sub_elements->groupBy(function ($q){
            return $q->check_point_id;
        }) as $check_point) {
            $off = false;
            foreach($check_point as $se){

                if($se->device->from_bio == 1) {
                    $state =  DB::connection('bioseguridad')
                            ->table('reports')
                            ->where('grd_id',$se->device->internal_id)
                            ->first()->state ?? 0;
                } else {
                    if($se->device->from_dpl == 1) {
                        $state =  DB::connection('dpl')
                                ->table('reports')
                                ->where('grd_id',$se->device->internal_id)
                                ->first()->state ?? 0;
                    } else {
                        if($se->device->report->state == 0) {
                            $state = 0;
                        }
                    }
                }

                if($state = 0) {
                    $off = true;
                }
            }
            if($off) {
                $offline++;
            }
        }
        $data = array();
        $data['offline'] = $offline;
        return json_encode($data,JSON_NUMERIC_CHECK);
    }
}
