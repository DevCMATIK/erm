<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Controllers;


use App\App\Controllers\Controller;

class AlarmListController extends Controller
{
    public function __invoke()
    {
        return view('water-management.device.sensor.alarm.list');
    }
}
