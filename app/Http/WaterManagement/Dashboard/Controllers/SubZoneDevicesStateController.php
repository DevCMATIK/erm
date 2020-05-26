<?php

namespace App\Http\WaterManagement\Dashboard\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

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
                if($se->device->report->state == 0) {
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
