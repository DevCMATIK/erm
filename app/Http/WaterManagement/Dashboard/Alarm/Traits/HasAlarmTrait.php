<?php
namespace App\Http\WaterManagement\Dashboard\Alarm\Traits;

use App\App\Traits\Dates\DateUtilitiesTrait;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Audit;
use Sentinel;



trait HasAlarmTrait
{
    use DateUtilitiesTrait;

    protected function query()
    {
        return SensorAlarmLog::query()
            ->join('sensor_alarms','sensor_alarms.id','=','sensor_alarm_logs.sensor_alarm_id')
            ->join('sensors','sensors.id','=','sensor_alarms.sensor_id')
            ->leftJoin('users','sensor_alarm_logs.accused_by','=','users.id')
            ->join('devices','devices.id','=','sensors.device_id')
            ->join('check_points','devices.check_point_id','=','check_points.id')
            ->leftJoin('sub_zone_sub_elements','sub_zone_sub_elements.device_id','=','devices.id')
            ->leftJoin('sub_zone_elements','sub_zone_sub_elements.sub_zone_element_id','=','sub_zone_elements.id')
            ->leftJoin('sub_zones','sub_zones.id','=','sub_zone_elements.sub_zone_id')
            ->leftJoin('zones','zones.id','=','sub_zones.zone_id')
            ->leftJoin('alarm_notifications','sensor_alarms.id','=','alarm_notifications.alarm_id')
            ->whereIn('devices.id',$this->getDevicesId()) //CRUD Alarmas Activas
            ->whereNull('sensor_alarms.deleted_at');
    }

    protected function queryLog()
    {
        return \OwenIt\Auditing\Models\Audit::query();

    }

    protected function activeAlarmQuery()
    {
        return $this->query()
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
            ]);
    }

    protected function lastAlarmQuery()
    {
        return $this->query()
        //->whereNotNull('sensor_alarm_logs.end_date') //CRUD Ultimas Alarmas
        ->select([
                DB::raw('distinct(sensor_alarm_logs.id) as log_id'),
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
                'users.first_name as first_name',
                'users.last_name as last_name',
                'sensor_alarm_logs.sensor_alarm_id as s_alarm_id'
        ])->whereIn('sensor_alarm_logs.id', function($q){
                 $q->select(DB::raw('MAX(id) FROM sensor_alarm_logs GROUP BY sensor_alarm_id'));
        })
        ->orderBy('sensor_alarm_logs.id','DESC');
    }

    protected function activeAlarmData()
    {
        return $this->activeAlarmQuery()->get()->unique('log_id');

    }

    protected function resolveParameters($request, $query,$parameters)
    {
        foreach($parameters as $field => $parameter) {
            if($request->has($parameter) && $request->{$parameter} !== null && count($request->{$parameter}) > 0) {
                $query = $query->search($field,$request->{$parameter});
            }
        }
        return $query;
    }

    protected function getZones()
    {
        return Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['sub_zones' => $filter,'sub_zones.sub_elements'])->get();
    }

    protected function getDevicesId()
    {
        $ids = array();
        foreach($this->getZones() as $zone) {
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

    protected function getActiveAlarmsWithParameters(Request $request)
    {
        return $this->handleDates($this->resolveParameters($request,$this->activeAlarmQuery(),[
            'zones.id'              => 'zones',
            'sub_zones.id'          => 'sub_zones',
            'check_points.type_id'  => 'type_checkPoint',
            'sensors.type_id'       => 'type_sensor',
            'alarms.type_id'        => 'type_alarms',
        ]),$request->dates,'start_date');
    }



    protected function getLastAlarmsWithParameters(Request $request)
    {
        return $this->handleDates($this->resolveParameters($request,$this->lastAlarmQuery(),[
            'zones.id'              => 'zones',
            'sub_zones.id'          => 'sub_zones',
            'check_points.type_id'  => 'type_checkPoint',
            'sensors.type_id'       => 'type_sensor',
            'alarms.type_id'        => 'type_alarms',
        ]),$request->dates,'start_date');
    }

}
