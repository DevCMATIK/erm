<?php

namespace App\Http\WaterManagement\Admin\Device\Controllers;

use App\Domain\WaterManagement\Device\Device;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class OfflineDevicesController extends Controller
{
    public function index()
    {
        return view('water-management.admin.device.offline.index');
    }



    public function getLogView($device_id)
    {
        $device = Device::with('check_point.sub_zones')->find($device_id);
        return view('water-management.admin.device.offline.log',compact('device'));
    }
}
