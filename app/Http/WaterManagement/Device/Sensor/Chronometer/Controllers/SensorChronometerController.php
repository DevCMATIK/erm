<?php

namespace App\Http\WaterManagement\Device\Sensor\Chronometer\Controllers;

use App\App\Controllers\Controller;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\SensorChronometer;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;

class SensorChronometerController extends Controller
{
    public function index(Request $request)
    {
        $sensor = Sensor::findOrFail($request->sensor_id);
        return view('water-management.device.sensor.chronometer.index',compact('sensor'));
    }

    public function create()
    {
        return view('water-management.device.sensor.chronometer.create');
    }

    public function store(Request $request)
    {
        if ($new = SensorChronometer::create([
            'sensor_id' => $request->sensor_id,
            'name' => $request->name,
            'equals_to' => $request->equals_to
        ])) {
            addChangeLog('Cronometro creado','sensor_chronometers',convertColumns($new));
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $chronometer = SensorChronometer::findOrFail($id);
        return view('water-management.device.sensor.chronometer.edit',compact('chronometer'));
    }

    public function update(Request $request,$id)
    {
        $chronometer = SensorChronometer::findOrFail($id);
        $old = convertColumns($chronometer);
            if ($chronometer->update([
                'name' => $request->name,
                'equals_to' => $request->equals_to,
            ])) {
                addChangeLog('Cronometro Modificado','sensor_chronometers',$old,convertColumns($chronometer));

                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }

    }

    public function destroy($id)
    {
        $chronometer = SensorChronometer::findOrFail($id);

        if ($chronometer->delete()) {
            addChangeLog('Cronometro Eliminado','sensor_chronometers',convertColumns($chronometer));

            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
