<?php

namespace App\Http\WaterManagement\Dashboard\Controllers;

use App\Domain\Client\Zone\Sub\SubZoneSubElement;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class AlarmAccusedController extends Controller
{
    public function __invoke($sub_element)
    {
        $sub_element = SubZoneSubElement::with(['check_point.devices.active_and_not_accused_alarm.active_alarm.last_log'])->find($sub_element);
        foreach($sub_element->check_point->devices as $device) {
            foreach($device->active_and_not_accused_alarm as $alarms){

                foreach($alarms->active_alarm as $alarm){
                    foreach($alarm->last_log as $log) {
                        if($log->accused_by == null) {
                            SensorAlarmLog::find($log->id)->update([
                                'accused' => 1,
                                'accused_by' => Sentinel::getUser()->id,
                                'accused_at' => Carbon::now()->toDateTimeString()
                            ]);
                            break;
                        }
                    }

                }
            }
        }


    }
}
