<?php

namespace App\Http\WaterManagement\Dashboard\Kpi;

use App\Domain\WaterManagement\Device\Device;
use App\App\Controllers\Controller;
use Sentinel;

class OnlineDevicesController extends Controller
{
    public function __invoke()
    {
        $devices = Device::with('report','check_point.sub_zones.zone')
            ->whereHas('check_point',function($q){
            return $q->whereHas('sub_zones',function($q){
                return $q->whereIn('id',Sentinel::getUser()->getSubZonesIds());
            });
        })->get();

        $offline = $devices->filter(function($device){
            return optional($device->report)->state === 0;
        })->count();

        $online = $devices->filter(function($device){
            return optional($device->report)->state === 1;
        })->count();

        $total = $online + $offline;
        return "{$offline}/{$total}";
    }
}
