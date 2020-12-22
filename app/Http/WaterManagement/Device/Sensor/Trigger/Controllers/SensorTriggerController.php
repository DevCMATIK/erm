<?php

namespace App\Http\WaterManagement\Device\Sensor\Trigger\Controllers;

use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTrigger;
use App\Http\WaterManagement\Device\Sensor\Trigger\Requests\SensorTriggerRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class SensorTriggerController extends Controller
{
    public function index(Request $request)
    {
        $sensor = Sensor::find($request->sensor_id);
        return view('water-management.device.sensor.trigger.index',
            [
                'sensor_id' => $request->sensor_id,
                'sensor' => $sensor
            ]
        );
    }

    public function create(Request $request)
    {
        $sensor_id = $request->sensor_id;
        $sensor = Sensor::with('address')->find($sensor_id);
        $devices = Device::with(['sensors' => function($q) {
            $q->output();
        },'check_point.sub_zones'])->get();
        return view('water-management.device.sensor.trigger.create',compact('sensor_id', 'devices','sensor'));
    }

    public function store(SensorTriggerRequest $request)
    {
        if (SensorTrigger::create(array_merge($request->all(),[
            'user_id' => Sentinel::getUser()->id
        ]))) {
            //addChangeLog('Trigger Creado','sensor_triggers',convertColumns($new));

            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }

    }

    public function update(SensorTriggerRequest $request,$id)
    {
        $sensor = SensorTrigger::find($id);
        //$old = convertColumns($sensor);
        if ($sensor->update(array_merge($request->all(),[
            'user_id' => Sentinel::getUser()->id
        ]))) {
            //addChangeLog('Trigger Modificado','sensor_triggers',$old,convertColumns($sensor));

            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }
    }

    public function edit($id)
    {
        $trigger = SensorTrigger::find($id);
        $sensor = Sensor::with('address')->find($trigger->sensor_id);
        $devices = Device::with(['sensors' => function($q) {
            $q->output();
        },'check_point.sub_zones'])->get();
        return view('water-management.device.sensor.trigger.edit',compact('trigger', 'devices','sensor'));

    }

    public function destroy($id)
    {
        $sensorTrigger = SensorTrigger::findOrFail($id);
        $sensorTrigger->logs()->delete();
        if ($sensorTrigger->delete()) {
            //addChangeLog('Trigger Eliminado','sensor_triggers',$sensorTrigger);

            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
