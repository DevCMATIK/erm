<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarm;
use App\App\Controllers\Controller;

class AlarmLogController extends Controller
{
    public function __invoke($id)
    {
        $alarm = SensorAlarm::with([
            'logs'  => function($q){
                            $q->take(50)->orderBy('id','desc');
            },
            'sensor.address'])->find($id);
        return view('water-management.device.sensor.alarm.log',compact('alarm'));
    }
}
