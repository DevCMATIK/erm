<?php

namespace App\Http\WaterManagement\Dashboard\Chart;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Device\DeviceDataCheck;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ChartController extends Controller
{
    public function index($device_id,$sensor_id)
    {
        $sensor = Sensor::with('type.interpreters')->find($sensor_id);
        $device = Device::with('sensors.address')->find($device_id);
        $devices = Device::with('sensors.address')->where('check_point_id',$device->check_point_id)->get();
        return view('water-management.dashboard.chart.index', compact('device_id','sensor_id','sensor','device','devices'));
    }

    public function indexExternal($device_id,$sensor_id)
    {
        $sensor = Sensor::with('type.interpreters','dispositions','selected_disposition')->find($sensor_id);
        $device = Device::with('sensors.address')->find($device_id);
        $devices = Device::with('sensors.address')->where('check_point_id',$device->check_point_id)->get();
        return view('water-management.dashboard.chart.index-external', compact('device_id','sensor_id','sensor','device','devices'));
    }
}
