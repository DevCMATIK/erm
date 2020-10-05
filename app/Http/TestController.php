<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\Domain\Client\CheckPoint\Indicator\CheckPointIndicator;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\ChronometerTracking;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends Controller
{


    public function __invoke(Request $request)
    {

        $zones = $this->getZones();

        $alarm_logs =
            SensorAlarmLog::join('sensor_alarms','sensor_alarms.id','=','sensor_alarm_logs.sensor_alarm_id')
            ->join('sensors','sensors.id','=','sensor_alarms.sensor_id')
            ->join('devices','devices.id','=','sensors.device_id')
            ->join('check_points','devices.check_point_id','=','check_points.id')
            ->leftJoin('sub_zone_sub_elements','sub_zone_sub_elements.device_id','=','devices.id')
            ->leftJoin('sub_zone_elements','sub_zone_sub_elements.sub_zone_element_id','=','sub_zone_elements.id')
            ->leftJoin('sub_zones','sub_zones.id','=','sub_zone_elements.sub_zone_id')
            ->leftJoin('users','sensor_alarm_logs.accused_by','=','users.id')
            ->leftJoin('zones','zones.id','=','sub_zones.zone_id')
            ->leftJoin('alarm_notifications','sensor_alarms.id','=','alarm_notifications.alarm_id')
            ->whereIn('devices.id',$this->getDevicesId($zones))
            ->whereNull('sensor_alarms.deleted_at')
            ->whereNotNull('sensor_alarm_logs.end_date')
            ->select([
                'zones.name as zone',
                'sub_zones.name as sub_zone',
                'check_points.name as device',
                'sensors.name as sensor',
                'sensor_alarm_logs.start_date as start_date',
                'sensor_alarm_logs.end_date as end_date',
                'sensor_alarm_logs.last_value_readed as last_value',
                'sensor_alarm_logs.first_value_readed as first_value_readed',
                'sensor_alarm_logs.min_or_max as type',
                'sensor_alarm_logs.accused as accused',
                'sensor_alarm_logs.accused_at as accused_at',
                'sensor_alarm_logs.id as log_id',
                'users.first_name as first_name',
                'users.last_name as last_name',
            ])->whereIn('sensor_alarm_logs.id', function($q){
                    $q->select(DB::raw('MAX(id) FROM sensor_alarm_logs GROUP BY sensor_alarm_id'));
                })
            ->take(50)
            ->orderBy('sensor_alarm_logs.id','DESC')
            ->get();

        dd($alarm_logs);
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
