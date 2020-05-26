<?php

namespace App\Http\WaterManagement\Dashboard\Controllers;

use App\Domain\Client\Zone\Zone;
use App\App\Controllers\Controller;
use Sentinel;

class ZoneDevicesStateController extends Controller
{
    public function __invoke($zone_id)
    {
        $sub_zones  = Zone::with([
            'sub_zones.sub_elements.check_point.devices.report'
        ])->find($zone_id)->sub_zones->filter(function($sub_zone){
            return Sentinel::getUser()->inSubZone($sub_zone->id) && isset($sub_zone->configuration);

        });
        return $this->getDevicesStatus($sub_zones);
    }

    protected function getDevicesStatus($sub_zones)
    {
        $offline = 0;
        foreach($sub_zones as $sub_zone) {

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
        }
        $data = array();
        $data['offline'] = $offline;
        return json_encode($data,JSON_NUMERIC_CHECK);
    }
}
