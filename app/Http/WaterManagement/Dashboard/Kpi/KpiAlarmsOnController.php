<?php

namespace App\Http\WaterManagement\Dashboard\Kpi;

use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;


class KpiAlarmsOnController extends Controller
{
    public function __invoke()
    {
        $zones = $this->getZones();

        return SensorAlarmLog::join('sensor_alarms','sensor_alarms.id','=','sensor_alarm_logs.sensor_alarm_id')
            ->join('sensors','sensors.id','=','sensor_alarms.sensor_id')
            ->join('devices','devices.id','=','sensors.device_id')
            ->whereNull('sensor_alarms.deleted_at')
            ->whereIn('devices.id',$this->getDevicesId($zones))
            ->active()
            ->count();

    }

    protected function getZones()
    {
        return Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['sub_zones' => $filter,'sub_zones.sub_elements'])->get();
    }

    protected function getDevicesId($zones)
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
