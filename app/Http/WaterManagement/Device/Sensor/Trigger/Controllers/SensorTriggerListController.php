<?php

namespace App\Http\WaterManagement\Device\Sensor\Trigger\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTrigger;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class SensorTriggerListController extends Controller
{
    public function index()
    {
        return view('water-management.device.sensor.trigger.list');
    }

    public function getLog($trigger)
    {
        $trigger = SensorTrigger::with(['sensor.device.check_point.sub_zones','logs' => function($q){
            $q->take(50)->orderBy('last_execution','desc');
        },'receptor.device','user','sensor.device'])->find($trigger);

        return view('water-management.device.sensor.trigger.logs',compact('trigger'));
    }
}
