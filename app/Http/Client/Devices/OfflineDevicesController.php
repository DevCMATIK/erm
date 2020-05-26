<?php

namespace App\Http\Client\Devices;

use App\Domain\WaterManagement\Device\Device;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class OfflineDevicesController extends Controller
{
    public function index()
    {
        return view('client.devices.index');
    }


    public function list()
    {
        return view('client.devices.list');
    }


    public function getLog($id)
    {
        $device = Device::with('check_point.sub_zones')->find($id);
        return view('client.devices.log',compact('device'));
    }
}
