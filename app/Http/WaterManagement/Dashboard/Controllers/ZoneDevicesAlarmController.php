<?php

namespace App\Http\WaterManagement\Dashboard\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class ZoneDevicesAlarmController extends Controller
{
    public function __invoke($zone_id)
    {
        $sub_zones  = Zone::with([
            'sub_zones.sub_elements.device.active_and_not_accused_alarm',
            'sub_zones.sub_elements.device.active_and_accused_alarm',
        ])->find($zone_id)->sub_zones->filter(function($sub_zone){
            return Sentinel::getUser()->inSubZone($sub_zone->id) && isset($sub_zone->configuration);

        });
        return $this->getDevicesStatus($sub_zones);
    }

    protected function getDevicesStatus($sub_zones)
    {
        $active = 0;
        $accused = 0;
        foreach($sub_zones as $sub_zone) {
            foreach($sub_zone->sub_elements as $sub_element) {
                if($sub_element->device->active_and_not_accused_alarm->count() > 0) {
                    $active++;
                }
                if($sub_element->device->active_and_accused_alarm->count() > 0) {
                    $accused++;
                }
            }
        }

        $data = array();
        $data['active'] = $active;
        $data['accused'] = $accused;
        return json_encode($data,JSON_NUMERIC_CHECK);
    }
}
