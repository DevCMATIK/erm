<?php

namespace App\Http\WaterManagement\Dashboard\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class SubZoneDevicesAlarmController extends Controller
{
    public function __invoke($sub_zone_id)
    {
        $sub_zone = SubZone::with([
            'sub_elements.device.active_and_not_accused_alarm',
            'sub_elements.device.active_and_accused_alarm',
        ])
            ->find($sub_zone_id);
        return $this->getDevicesStatus($sub_zone);
    }

    protected function getDevicesStatus($sub_zone)
    {
        $active = 0;
        $accused = 0;
        foreach($sub_zone->sub_elements as $sub_element) {
            if(optional($sub_element->device)->active_and_not_accused_alarm->count() > 0) {
                $active++;
            }
            if(optional($sub_element)->device->active_and_accused_alarm->count() > 0) {
                $accused++;
            }
        }
        $data = array();
        $data['active'] = $active;
        $data['accused'] = $accused;
        return json_encode($data,JSON_NUMERIC_CHECK);
    }
}
