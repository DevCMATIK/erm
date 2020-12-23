<?php

namespace App\Http\WaterManagement\Device\Controllers;

use App\App\Traits\Views\HasNavBarTrait;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Type\DeviceType;
use App\Http\WaterManagement\Device\Requests\DeviceRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class DeviceController extends Controller
{
    use HasNavBarTrait;

    public function index(Request $request)
    {
        $checkPointTypes = CheckPointType::with([
            'check_points.devices.sensors'
        ])->get();
        $navBar = $this->makeNavBar($checkPointTypes,[
            'check_point_types' => [
                'url' => '/check-points?type=',
                'field' => 'slug',
                'name' => 'name',
                'alter' => 'Ver Check Points'
            ],
            'check_points' => [
                'url' => '/devices?check_point_id=',
                'field' => 'id',
                'name' => 'name',
                'alter' => 'Ver Dispositivos'
            ],
            'devices' => [
                'url' => '/sensors?device_id=',
                'field' => 'id',
                'name' => 'name',
                'alter' => 'Ver Sensores'
            ],
            'sensors' => [
                'name' => 'full_address'
            ]
        ]);
        $checkPoint = CheckPoint::findOrFail($request->check_point_id);
        return view('water-management.device.index',
            [
                'check_point_id' => $request->check_point_id,
                'checkPoint' => $checkPoint,
                'navBar' => $navBar
            ]
        );
    }

    public function create(Request $request)
    {
        $types = DeviceType::get();
        $check_point_id = $request->check_point_id;
        return view('water-management.device.create',compact('check_point_id','types'));
    }

    public function store(DeviceRequest $request)
    {
        if (Device::create(array_merge($request->all(),[
            'from_bio' => ($request->has('from_bio'))?1:0
        ]))) {
            //addChangeLog('dispositivo Creado','devices',null,convertColumns($device));

            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }

    }

    public function edit($id)
    {
        $types = DeviceType::get();
        $device = Device::findOrFail($id);
        return view('water-management.device.edit',compact('types','device'));
    }

    public function update(DeviceRequest $request,$id)
    {
        $device = Device::findOrFail($id);
        //$old = convertColumns($device);
        if ($device->update(array_merge($request->all(),[
            'from_bio' => ($request->has('from_bio'))?1:0
        ]))) {
            //addChangeLog('Dipositivo Modificado','devices',$old,convertColumns($device));

            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }
    }

    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        if ($device->delete()) {
            //addChangeLog('Dispositivo eliminado','devices',convertColumns($device));

            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
