<?php

namespace App\Http\WaterManagement\Dashboard\Alarm\Controllers;

use App\Domain\Client\Zone\Zone;
use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;


class ActiveAlarmsTableController extends Controller
{
    public function index()
    {
        $zones = $this->getZones();

        $alarm_logs =  SensorAlarmLog::join('sensor_alarms','sensor_alarms.id','=','sensor_alarm_logs.sensor_alarm_id')
            ->join('sensors','sensors.id','=','sensor_alarms.sensor_id')
            ->join('users','sensor_alarm_logs.accused_by','=','users.id')
            ->join('devices','devices.id','=','sensors.device_id')
            ->join('check_points','devices.check_point_id','=','check_points.id')
            ->leftJoin('sub_zone_sub_elements','sub_zone_sub_elements.device_id','=','devices.id')
            ->leftJoin('sub_zone_elements','sub_zone_sub_elements.sub_zone_element_id','=','sub_zone_elements.id')
            ->leftJoin('sub_zones','sub_zones.id','=','sub_zone_elements.sub_zone_id')
            ->leftJoin('zones','zones.id','=','sub_zones.zone_id')
            ->leftJoin('alarm_notifications','sensor_alarms.id','=','alarm_notifications.alarm_id')
            ->whereIn('devices.id',$this->getDevicesId($zones))
            ->whereNull('sensor_alarms.deleted_at')
            ->active()
            ->select([
                'zones.name as zone',
                'sub_zones.name as sub_zone',
                'sub_zones.id as sub_zone_id',
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
                'sensor_alarm_logs.sensor_alarm_id as alarm_id',
                'users.first_name as first_name',
                'users.last_name as last_name',
            ])
            ->get()->unique('log_id');;

        return view('water-management.dashboard.alarm.active-table',compact('alarm_logs'));
    }

    public function remindMeAlarm(Request $request)
    {
        $val = explode('_',$request->element);
        User::find($val[2])->alarm_reminders()->toggle($val[1]);
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
