<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\Domain\Client\CheckPoint\Indicator\CheckPointIndicator;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\ChronometerTracking;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Http\Data\Jobs\CheckPoint\ReportToDGA;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends Controller
{


    public function __invoke(Request $request)
    {
        ReportToDGA::dispatch(1)->onQueue('long-running-queue-low');
    }


    protected function getZones()
    {
        return Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['sub_zones' => $filter],'sub_zones.sub_elements')->get();
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

        return collect($ids)->unique()->toArray();
    }
}
